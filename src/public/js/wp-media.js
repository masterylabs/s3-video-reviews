function mlWPMedia(){var t={type:"image"};window.addEventListener("message",function(e){if("string"==typeof e.data&&function(t){try{JSON.parse(t)}catch(t){return!1}return!0}(e.data)){var n,a,i=JSON.parse(e.data);if(i.action&&"ml_wp_media"===i.action)i.anyFormat&&(t={}),n=function(t){var n=JSON.stringify({id:i.id,url:t,action:i.action});document.getElementById("ml_app").contentWindow.postMessage(n,"*"),e.source.postMessage(n,"*")},(a=window.wp.media({title:"Insert a media",library:t,multiple:!1,button:{text:"Insert"}})).on("select",function(){var t=a.state().get("selection").first().toJSON();n(t.url),a.close()}),a.open()}})}mlWPMedia();
