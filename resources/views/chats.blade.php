@extends('layouts.dashboard')
@section('chats.index','sidebar-active')
@section('site-title','- Pesan')

@section('content')
<div class="modal fade" id="newChatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post" onsubmit="sendMessage(this); return false;">
    <input type="hidden" name="post_as_id" value="">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 0px;">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pesan Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn z-techno-btn z-techno-secondary" style="border:1px solid #f6922d;"><i class="fa fa-search"></i></button>
                </span>
                <input type="text" name="search-person" class="form-control z-techno-el" style="height: auto;" placeholder="Cari Seseorang ..." onkeyup="searchPerson(this)">
                <div class="person-response"></div>
            </div>
            <p></p>
            <div class="form-group person-response-to"></div>

            <p></p>
            <div class="form-group">
                <label>Pesan</label>
                <textarea name="message" required="" class="form-control z-techno-el" style="resize: none;" rows="5" placeholder="Ketikkan pesan disini ..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn z-techno-btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button class="btn z-techno-btn btn-primary"><i class="fa fa-send"></i> Kirim Pesan</button>
        </div>
      </div>
    </div>
    </form>
</div>

<div class="container-fluid" style="border: 1px solid #bdb7b7;padding-top: 10px;padding-bottom: 10px;background-color: #FFF;">
    <div class="row" style="height: 100%">
        <div class="col-md-12 col-lg-4 chat-sidebar" style="border-right: 1px solid #bdb77b;">
            <div>
                <h4 class="pull-left"><i class="fa fa-envelope"></i> Pesan</h4>
                <button class="btn z-techno-btn z-techno-primary pull-right" data-toggle="modal" data-target="#newChatModal"><i class="fa fa-plus"></i> Buat Pesan</button>
                <div class="clearfix"></div>
            </div>
            <p></p>
            <div class="search-chat-section">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn z-techno-btn z-techno-secondary" style="border:1px solid #f6922d;"><i class="fa fa-search"></i></button>
                    </span>
                    <input type="text" name="search-chat" class="form-control z-techno-el" style="height: auto;" placeholder="Cari Pesan ...">
                </div>
            </div>
            <br>
            <div class="conversation"></div>
        </div>
        <div class="col-md-12 col-lg-8">
            <div class="active-user"></div>
            <div class="chat" style="height: 400px;overflow: auto;"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-4 chat-sidebar" style="border-right: 1px solid #bdb77b;"></div>
        <div class="col-md-12 col-lg-8">
            <form method="post" class="form-chat" style="display: none;" onsubmit="sendMessage2(this); return false;">
                <input type="hidden" name="id" value="">
                <div class="form-group">
                    <label>Pesan</label>
                    <textarea name="message" required="" class="form-control z-techno-el" style="resize: none;" rows="5" placeholder="Ketikkan pesan disini ..."></textarea>
                </div>
                <button class="btn z-techno-btn btn-primary"><i class="fa fa-send"></i> Kirim Pesan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" defer>
var es,saveMessageStatus = false,activeChat=0;
async function loadChats(url = false)
{
    $('.conversation').html("Loading...")
    if(!url)
        url = window.config.getApiUrl()+'/chats'
    let response = await fetch(url,{
        method:'POST',
        headers:{
            'Content-Type':'application/json'
        },
        body:JSON.stringify({
            user_id:'{{auth()->user()->id}}',
        })
    })

    let data = await response.json()
    window.id = data.id
    window.all_chats  = []
    data.all_chats.forEach(value => {
        var jsonData = JSON.parse('{"'+value.id+'":0}')
        window.all_chats.push(jsonData)
    })

    $('.conversation').html("")
    if(data.all_chats.length == 0)
    {
        $('.conversation').html('<center>'+data.html+'</center>')
        $('.chat').html('<center>'+data.html+'</center>')
    }
    else
    {
        setActiveChat(data.id)
        $('.conversation').html(data.html)
    }
    return data.id
}

async function searchPerson(el)
{
    var name = el.value
    if(el.value != '')
    {
        var school_id = '{{auth()->user()->school[0]->id}}'
        var user_id = '{{auth()->user()->id}}'
        var url = window.config.getApiUrl()+'/school/find/users'
        let response = await fetch(url,{
            method:'POST',
            headers:{
                'Content-Type':'application/json'
            },
            body: JSON.stringify({
                school_id:school_id,
                name:name,
                user_id:user_id
            })
        })

        let data = await response.json()
        $('.person-response').css('display','block')
        $('.person-response').html(data.html)
    }
    else
    {
        $('.person-response').html('')
    }
}

function setMessageTo(id, name, el)
{
    $('input[name=post_as_id]').val(id)
    $('input[name=search-person]').val(name)
    document.querySelector('.person-response').style.display='none'
    document.querySelector('.person-response-to').innerHTML = "<label style='display:block;'>Ke </label><button type='button' class='btn z-techno-btn btn-danger btn-sm' onclick='removeMessageTo()'><i class='fa fa-times'></i></button><p></p>"
    document.querySelector('.person-response-to').innerHTML += '<div style="margin-top:-30px;">'+el.innerHTML+'</div>'
}

function removeMessageTo()
{
    $('input[name=new_post_as_id]').val('')
    document.querySelector('.person-response-to').innerHTML = ''
}

async function sendMessage(el)
{
    var frm = $(el);
    var school_id = '{{auth()->user()->school[0]->id}}'
    var user_id = '{{auth()->user()->id}}'
    var post_as_id = frm.find('input[name=post_as_id]').val()
    var message = frm.find('textarea[name=message]').val()
    var url = window.config.getApiUrl()+'/post-chats'
    let response = await fetch(url,{
        method:'POST',
        headers:{
            'Content-Type':'application/json'
        },
        body: JSON.stringify({
            school_id:school_id,
            post_as_id:post_as_id,
            message:message,
            user_id:user_id
        })
    })

    el.reset()
    $('#newChatModal').modal('hide')
}

async function sendMessage2(el)
{
    var frm = $(el);
    var school_id = '{{auth()->user()->school[0]->id}}'
    var user_id = '{{auth()->user()->id}}'
    var id = frm.find('input[name=id]').val()
    var message = frm.find('textarea[name=message]').val()
    var url = window.config.getApiUrl()+'/post-chats'
    let response = await fetch(url,{
        method:'POST',
        headers:{
            'Content-Type':'application/json'
        },
        body: JSON.stringify({
            school_id:school_id,
            id:id,
            message:message,
            user_id:user_id
        })
    })

    el.reset()
}

function setActiveChat(id)
{
    activeChat = id
    var frm = $('.form-chat');
    frm.css('display','block')
    frm.find('input[name=id]').val(id)
    window.all_chats[id] = 0

    setTimeout(() => {
        $('.chat-items').removeClass('chat-active')
        $('.chat-id-'+id).addClass('chat-active')
    },100)
}

function setupStream() {
    // Not a real URL, just using for demo purposes
    if(es != undefined)
    {
        es.close()
        console.log('connection closed')
    }

    es = new EventSource(window.config.getApiUrl()+'/retrieve-chats/{{auth()->user()->id}}');

    es.addEventListener('newChats', event => {
        let data = event.data;
        if(data != 0)
        {
            data = JSON.parse(data)
            if(data.id != window.id)
            {
                window.id = data.id
                // let old = $('.post-list').html();
                // data = data.html // + '' + old
                $('.conversation').html(data.html)
            }

            saveMessageStatus = false
        }
    }, false);

    es.addEventListener('newMessage', event => {
        let data = event.data;
        if(data != 0)
        {
            data = JSON.parse(data)
            data.forEach(value => {
                if(window.all_chats[value.post_id] != value.comment_id && activeChat == value.post_id)
                {
                    $('.chat').html(value.html)
                    document.querySelector('.chat-items.chat-id-'+value.post_id+' .comment-content.chat-list p').innerHTML = value.contents
                    var objDiv = document.querySelector(".chat");
                    objDiv.scrollTop = objDiv.scrollHeight;
                    window.all_chats[value.post_id] = value.comment_id
                }
            })
        }
    }, false);

    es.addEventListener('error', event => {
        if (event.readyState == EventSource.CLOSED) {
            console.log('Event was closed');
            console.log(EventSource);
        }
    }, false);
}

loadChats().then(id => {
    setupStream();
});
</script>
@endsection