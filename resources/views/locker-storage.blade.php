@extends('layouts.dashboard')
@section('local-storage.index','sidebar-active')
@section('site-title','- Penyimpanan Pribadi')

@section('content')
<div style="display: none;">
<form method="post" id="storageForm">
<input type="file" id="storageFile" name="file[]" multiple="" onchange="uploadAction()">
</form>
</div>
<div class="modal fade" id="folderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post" onsubmit="createFolder(this); return false;">
    <input type="hidden" name="folder_id" id="folder_id" value="{{$folder}}">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 0px;">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Buat Folder Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger alert-folder-fail" style="display: none;">Buat Folder Gagal</div>
            <div class="form-group">
                <label>Nama Folder</label>
                <input type="text" name="name" required="" class="form-control z-techno-el" placeholder="Nama folder disini ...">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn z-techno-btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button class="btn z-techno-btn btn-primary"><i class="fa fa-send"></i> Simpan</button>
        </div>
      </div>
    </div>
    </form>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-wrapper">
                <h2>Penyimpanan Pribadi</h2>
                <p>
                    <a href="javascript:void(0)" class="btn z-techno-btn z-techno-primary" onclick="storageFile.click()"><i class="fa fa-cloud-upload"></i> Upload File</a>
                    <a href="javascript:void(0)" class="btn z-techno-btn z-techno-primary" data-toggle="modal" data-target="#folderModal"><i class="fa fa-plus"></i> Buat Folder Baru</a>
                    @if($folder)
                    <a href="{{route('locker-storage.folder',$parent->parent_id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    @endif
                </p>
                @if ($message = Session::get('success'))
                  <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                  </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped file-table">
                        <thead>
                        <tr>
                            <th width="50px">#</th>
                            <th>Nama</th>
                            <th>Uploaded At</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" defer>
async function loadFile()
{
    var number = 1
    let response = await fetch(window.config.getApiUrl()+'/files/index/'+folder_id.value,{
        'method':'POST',
        'headers': {
            'Content-Type':'application/json'
        },
        'body': JSON.stringify({
            user_id:{{auth()->user()->id}}
        })
    })
    let data = await response.json()

    $('.file-table > tbody').html('')
    if(data.files.length == 0 && data.folders.length == 0)
        $('.file-table > tbody').append('<tr><td colspan=3><i>Tidak ada data</i></td></tr>')
    else
    {
        data.folders.forEach(val => {
            $('.file-table').append(`<tr>
                <td>${number++}</td>
                <td>
                <b>
                <a href='{{route('locker-storage.index')}}/${val.id}'>
                    <i class='fa fa-folder'></i> ${val.name}
                </a>
                </b>
                </td>
                <td></td>
            </tr>`)
        })

        data.files.forEach(val => {
            var visibility = val.visibility == null || val.visibility == 0 ? 0 : 1;
            visibility = val.visibility ? 'Set Private' : 'Set Public'
            $('.file-table').append(`<tr>
                <td>${number++}</td>
                <td>
                <a href='{{route('locker-storage.download')}}/${val.id}' class='file-name'>${val.name}</a><br>
                <div class='file-panel'> 
                <a href='{{route('locker-storage.download')}}/${val.id}'>
                    <i class='fa fa-cloud-download'></i> Unduh
                </a>
                &nbsp;&nbsp;
                <a href='javascript:void(0)' onclick='updateVisibility(${val.id})'>
                    <i class='fa fa-pencil'></i> ${visibility}
                </a>
                &nbsp;&nbsp;
                <a href='javascript:void(0)' style='color:red' onclick='deleteFile(${val.id})'>
                    <i class='fa fa-trash'></i> Hapus
                </a>
                </div>
                </td>
                <td>${val.created_at}</td>
            </tr>`)
        })
    }

}

async function uploadAction()
{
    var files = storageFile.files
    var formData = new FormData()
    Object.keys(files).forEach(index => {
        formData.append('file['+index+']', files[index]);
    })
    formData.append('parent_id', folder_id.value)
    formData.append('user_id', {{auth()->user()->id}})
    let response = await fetch(window.config.getApiUrl()+'/files/upload',{
        'method':'POST',
        'body': formData
    })
    let data = await response.json()
    if(data.success)
        await loadFile()
    return false
}

async function deleteFile(id)
{
    if(!confirm('Apakah anda yakin akan menghapus file ini ?'))
        return false
    var formData = new FormData()
    formData.append('id', id)
    formData.append('user_id', {{auth()->user()->id}})
    let response = await fetch(window.config.getApiUrl()+'/files/delete',{
        'method':'POST',
        'body': formData
    })
    let data = await response.json()
    if(data.success)
        await loadFile()
    return false
}

async function updateVisibility(id)
{
    if(!confirm('Apakah anda yakin akan mengubah status file ini ?'))
        return false
    var formData = new FormData()
    formData.append('id', id)
    formData.append('user_id', {{auth()->user()->id}})
    let response = await fetch(window.config.getApiUrl()+'/files/update-visibility',{
        'method':'POST',
        'body': formData
    })
    let data = await response.json()
    if(data.success)
        await loadFile()
    return false
}

async function createFolder(form)
{
    $('.alert-folder-fail').css('display','none')
    $frm = $(form)
    var name = $frm.find('input[name=name]').val()
    let response = await fetch(window.config.getApiUrl()+'/folder/create',{
        'method':'POST',
        'headers': {
            'Content-Type':'application/json'
        },
        'body': JSON.stringify({
            user_id:{{auth()->user()->id}},
            name:name,
            parent_id:folder_id.value
        })
    })
    let data = await response.json()

    if(data.success)
    {
        $('#folderModal').modal('hide')
        form.reset()
        await loadFile()
    }
    else
    {
        $('.alert-folder-fail').css('display','block')
    }
}

loadFile()
</script>
@endsection