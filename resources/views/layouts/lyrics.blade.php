<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/datatable.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
</head>
<body>

Logged as:{{$userName}}

<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
	<a class="dropdown-item toright" href="{{ route('logout') }}"
	   onclick="event.preventDefault();
	                 document.getElementById('logout-form').submit();">
	    {{ __('Logout') }}
	</a>
<br><br>
	<a class="dropdown-item" href="/lyrics/create" id="newLyrics">
	   
	    {{ __('Create new lyrics') }}
	</a>

<br><br>
	   
	  {{ __('Edit/Delete lyrics') }}
	 <select id="editEntry">
	 		<option value="0"></option>
	    	@foreach($entryTitle as$key => $value)
	    	<option value="{{$entryId[$key]}}">{{$value}}</option>
	    	@endforeach
	  </select>
<br><br>
	   
	   <a class="dropdown-item" id="showAll" href="/"
	   onclick="event.preventDefault()">
	    {{ __('Show lists of lyrics') }}
	</a>
	 

	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	    @csrf
	</form>

</div>
<br>
<div id="displayArea">
	
</div>
</body>

<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('js/datatable.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
  $("#newLyrics").click(function(evt){
  	evt.preventDefault();
  	const data = entry("new");
  	const up = $("#editEntry");
  	up.val(0);
  	data.submitBtn.addEventListener("click",()=>{
  		if(checkData({title:data.title.value,artist:data.artist.value,lyrics:data.lyrics.value},data)){
  		let token = "{{csrf_token()}}";
		let conn = fetch("/lyrics",{method:'POST',
		           headers:{
		           	"Content-Type":"application/json",
		           	"X-CSRF-Token": token
		           },
		           body:JSON.stringify({title:data.title.value,artist:data.artist.value,lyrics:data.lyrics.value})
		       });
		    conn.then(res => res.json()).then(res=> {data.msg.innerHTML = "Recorded Successfully";
		    	up.append(`<option value=${res}>${data.title.value}`);
		    	setTimeout(()=>data.msg.innerHTML = "",3000);
		    	up.val(res).trigger("change");
			});
	  	}
  	});
  });
  $("#editEntry").on("change",()=>{
  	 let id = $(this).find(":selected");
  	 if(parseInt(id.val()) > 0){
  	 let token = "{{csrf_token()}}";
		let conn = fetch(`/lyrics/${id.val()}/edit`);
		    conn.then(res => res.json()).then(res=>{
		    	const data = entry("up");
		    	      data.title.value = res.title;
		    	      data.artist.value = res.artist;
		    	      data.lyrics.value = res.lyrics;
		    	data.delBtn.classList.remove('hideme');
				data.submitBtn.addEventListener("click",()=>{
		  		if(checkData({title:data.title.value,artist:data.artist.value,lyrics:data.lyrics.value},data)){
					let conn2 = fetch(`/lyrics/${id.val()}`,{method:'PUT',
					           headers:{
					           	"Content-Type":"application/json",
					           	"X-CSRF-Token": token
					           },
					           body:JSON.stringify({title:data.title.value,artist:data.artist.value,lyrics:data.lyrics.value})
					       });
					    conn2.then(res => res.json()).then(res=>{
					     id[0].textContent = data.title.value;
					     data.msg.innerHTML = "Upated Successfully";
					     setTimeout(()=>data.msg.innerHTML = "",3000);
					 });
			  	}
		  		});
		  		data.delBtn.addEventListener("click",()=>{
		  		if(checkData({title:data.title.value,artist:data.artist.value,lyrics:data.lyrics.value},data)){
				let conn3 = fetch(`/lyrics/${id.val()}`,{method:'DELETE',
				           headers:{
				           	"Content-Type":"application/json",
				           	"X-CSRF-Token": token
				           },
				           body:JSON.stringify({title:data.title.value,artist:data.artist.value,lyrics:data.lyrics.value})
				       });
				    conn3.then(res => res.json()).then(res=>{id[0].remove();
				    data.msg.innerHTML = "Deleted Successfully";
				    data.title.value = "";
		    	    data.artist.value = "";
		    	    data.lyrics.value = "";
		    	    data.delBtn.classList.add("hideme");
				     setTimeout(()=>data.msg.innerHTML = "",3000);

				 });
			  	}
		  		});
		     });
	 } 	

  });

  $("#showAll").on("click",()=>{
  	$("#editEntry").val(0);
  		let conn = fetch(`/lyrics/0`);
		    conn.then(res => res.json()).then(res=>{dataTableContruct(res);
  		});
  });

});
function dataTableContruct(data){
	let str = `<table id="table_id">
				<thead>
			        <tr>
			            <th>Title</th>
			            <th>Artist</th>
			            <th>Lyrics</th>
			            <th>Created</th>
			        </tr>
			    </thead>`;
    str += '<tbody>';
    if(data.length > 0){
      for(let per in data){
      	 str += `<tr>
      	 		  <td>${data[per].title}</td>
      	 		  <td>${data[per].artist}</td>
      	 		  <td>${data[per].lyrics}</td>
      	 		  <td>${data[per].created_at}</td>
      	 		 </tr>`;
      }
    }
    str +=`</tbody></table>`;

	$("#displayArea").html(str);
	$('#table_id').DataTable();

}
function checkData(data,obj){
	let verified = true;
	for(let per in data){
		if(data[per].trim().length <= 0){
			obj[per].classList.add('err');
			verified = false;
		}else{
			obj[per].classList.remove('err');
		}
	}
	return verified;
}
function entry(perform){
	let container  = document.createElement("div");
	let msg        = document.createElement("div");
	let titleText  = document.createTextNode("Title: ");
	let title      = document.createElement("input");
		title.type = "text";
		title.id   = "newtitle";
		title.placeholder = "type title...";
		title.className   = "newLyricsEntry";
		container.append(titleText);
		container.append(title);
		container.append(document.createElement("br"));
		container.append(document.createElement("br"));
   let artistText   = document.createTextNode("Artist: ");
   let artist       = document.createElement("input");
		artist.type = "text";
		artist.id   = "newartist";
		artist.placeholder = "type artist...";
		artist.className   = "newLyricsEntry";
		container.append(artistText);
		container.append(artist);
		container.append(document.createElement("br"));
		container.append(document.createElement("br"));
   let lyricsText   = document.createTextNode("Lyrics: ");
   let lyrics       = document.createElement("textarea");
		lyrics.type = "text";
		lyrics.id   = "newlyrics";
		lyrics.placeholder = "type lyrics...";
		lyrics.className   = "textString";
		container.append(lyricsText);
		container.append(lyrics);
		container.append(document.createElement("br"));
   let submitBtn = document.createElement('input');
       submitBtn.type = "button";
   let delBtn = document.createElement('input');
       delBtn.type = "button";

       if(perform == "new"){
       	submitBtn.id   = "record";
       	submitBtn.value = "Save";
   		}else if(perform == "up"){
   		 submitBtn.id    = "update";
       	 submitBtn.value = "Update";
       	 delBtn.id       = "delBtn";
       	 delBtn.value    = "Delete";
       	 container.append(delBtn);
   		}
       container.append(submitBtn);
       msg.id = "msg";
       container.append(msg);
	$("#displayArea").html(container);
	return {title,artist,lyrics,submitBtn,msg,delBtn};
}
</script>
</html>
