<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
</head>
<body>

Logged as:{{$userName}}

<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
	<a class="dropdown-item" href="{{ route('logout') }}"
	   onclick="event.preventDefault();
	                 document.getElementById('logout-form').submit();">
	    {{ __('Logout') }}
	</a>
<br>
	<a class="dropdown-item" href="/lyrics/create" id="newLyrics">
	   
	    {{ __('Create new lyrics') }}
	</a>


	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	    @csrf
	</form>

	<form id="create-new" action="/lyrics/create" method="POST" style="display: none;">
	    @csrf
	</form>
</div>
<br>
<div id="displayArea">
	
</div>
</body>

<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#newLyrics").click(function(evt){
  	evt.preventDefault();
  	const data = newEntry();
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
		    conn.then(res => res.json()).then(res=>console.log(res));
	  	}
  	});
  });
});
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
function newEntry(){
	let container  = document.createElement("div");
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
       submitBtn.id   = "record";
       submitBtn.value = "Save";
       container.append(submitBtn);
	$("#displayArea").html(container);
	return {title,artist,lyrics,submitBtn};
}
</script>
</html>
