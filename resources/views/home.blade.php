@extends('layouts.dashboard')
@section('home-active','sidebar-active')
@section('site-title','- Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-9">
            <div style="overflow: hidden;">
                <div class="content-overlay" style="display:none;position: absolute;background-color: rgba(0,0,0,0.5);">
                    <center>
                    <p style="margin-top: 110px;color: #FFF;">Membagikan post...</p>
                    </center>
                </div>
            	@if(auth()->user()->isRole('siswa'))
                <div class="content-wrapper">
                	<h2 style="font-size: 16px;">Selamat Datang di e-School</h2>
                	<form method="post" class="form-posts" enctype="multipart/form-data" onsubmit="savePost(this); return false">
                		<div class="form-group posts-group">
                			<textarea name="contents" class="form-control z-techno-el" rows="5" style="resize: none;" placeholder="Katakan sesuatu tentang hari ini.."></textarea>
                            <!-- <div class="z-techno-btn-group">
                                <button type="button" id="fileUploadPostBtn" onclick="fileUploadPost.click()" class="btn z-techno-btn z-techno-btn-float">File</button>
                                <button type="button" id="gambarUploadPostBtn" onclick="gambarUploadPost.click()" class="btn z-techno-btn z-techno-btn-float">Gambar</button>
                            </div> -->
                			<select class="form-control z-techno-el select2" name="post_as">
                				<option value="Catatan Pribadi">Catatan Pribadi</option>
                                <option value="Semua Orang">Semua Orang</option>
                				<option value="Teman Sekelas">Teman Sekelas</option>
                			</select>
                		</div>
                		<button class="btn z-techno-btn z-techno-primary">Bagikan</button>
                	</form>
                </div>
                @else
                <div class="content-wrapper">
                	<h2 style="font-size: 16px;">Selamat Datang di e-School</h2>
                	<form method="post" class="form-posts" enctype="multipart/form-data" onsubmit="savePost(this); return false">
                		<div class="form-group posts-group">
                			<textarea name="contents" class="form-control z-techno-el" rows="5" style="resize: none;" placeholder="Katakan sesuatu tentang hari ini.."></textarea>
                			<!-- <div class="z-techno-btn-group">
                				<button type="button" id="fileUploadPostBtn" onclick="fileUploadPost.click()" class="btn z-techno-btn z-techno-btn-float">File</button>
                				<button type="button" id="gambarUploadPostBtn" onclick="gambarUploadPost.click()" class="btn z-techno-btn z-techno-btn-float">Gambar</button>
                			</div> -->
                			<select name="post_as" class="form-control z-techno-el select2" onchange="postType.style.display = 'none'; if(this.value != 'Catatan Pribadi' && this.value != 'Semua Orang' && this.value != '') postType.style.display = 'block'" required="">
                				<option value="">Bagikan Ke / Sebagai</option>
                				<option value="Semua Orang">Semua Orang</option>
                                <option value="Catatan Pribadi">Catatan Pribadi</option>
                				<option value="Pengumuman">Pengumuman</option>
                                <option value="Tugas">Tugas</option>
                                <option value="Materi">Materi</option>
                			</select>
                			<select class="form-control z-techno-el select2" id="postType" name="post_as_id" style="display: none;">
                				@foreach(auth()->user()->classrooms as $classroom)
                                <option value="{{$classroom->id}}">{{$classroom->name}}</option>
                                @endforeach
                			</select>
                			<div style="display: none">
                				<input type="file" name="file" id="fileUploadPost" onchange="fileUploadPostBtn.innerHTML = '1 File Terpilih'">
                				<input type="file" name="gambar" id="gambarUploadPost" onchange="gambarUploadPostBtn.innerHTML = '1 Gambar Terpilih'">
                			</div>
                		</div>
                		<button class="btn z-techno-btn z-techno-primary">Bagikan</button>
                	</form>
                </div>
                @endif
            </div>
            <br>

            <div class="post-list"></div>
        </div>

        <div class="col-lg-3 col-md-12">
        	
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" defer>
async function loadPosts(url = false)
{
    $('.post-list').html("Loading...")
    if(!url)
        url = window.config.getApiUrl()+'/get-posts'
    let response = await fetch(url,{
        method:'POST',
        headers:{
            'Content-Type':'application/json'
        },
        body:JSON.stringify({
            user_id:'{{auth()->user()->id}}',
        })
    })

    let data = await response.text()
    $('.post-list').html(data)

}

async function savePost(el)
{
    var frm = $(el);
    var contentWrapper = $('.content-wrapper');
    var overlay = $('.content-overlay');
    overlay.css('width',contentWrapper.outerWidth())
    overlay.css('height',contentWrapper.outerHeight())
    overlay.css('display','block')
    let response = await fetch(window.config.getApiUrl()+'/save-post',{
        method:'POST',
        headers:{
            'Content-Type':'application/json'
        },
        body:JSON.stringify({
            user_id:'{{auth()->user()->id}}',
            contents:$('textarea[name=contents]').val(),
            post_as:$('select[name=post_as]').val(),
            post_as_id:$('select[name=post_as_id]').val(),
        })
    })

    let data = await response.json()
    if(data.success)
    {
        await loadPosts()
        el.reset()
        $('select[name=post_as]').val('').change()
    }
    overlay.css('display','none')
    return false
}

async function saveComment(el)
{
    event.preventDefault();
    var frm = $(el)
    let response = await fetch(window.config.getApiUrl()+'/save-comment',{
        method:'POST',
        headers:{
            'Content-Type':'application/json'
        },
        body:JSON.stringify({
            user_id:frm.find('input[name=user_id]').val(),
            post_id:frm.find('input[name=post_id]').val(),
            contents:frm.find('textarea[name=contents]').val(),
        })
    })

    let data = await response.json()
    if(data.success)
        await loadPosts()
    return false
}

loadPosts();

$('body').on('click', '.pagination a', function(e) {
    e.preventDefault();

    var url = $(this).attr('href');  
    var page = window.getParam('page',url);
    loadPosts(url);
    window.history.pushState("", "", "#page-"+page);
});
</script>
@endsection