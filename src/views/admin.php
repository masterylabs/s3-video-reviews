<div id="ml_app_container"></div>
<script>
    let _mlAppFirstLoad = false
    function mlhash(n) {
        if(_mlAppFirstLoad) {
            console.log('move', n)
            window.location.hash = n;
        } else {
            console.log('first', n)
            _mlAppFirstLoad = true;
        }
	}

    var iframe = document.createElement('iframe');
    iframe.id = 'ml_app';
    iframe.className = 'ml-app';
    iframe.src = '<?php echo $url; ?>' + window.location.hash;
    document.getElementById('ml_app_container').appendChild(iframe);
    iframe.frameborder = 0;
</script>
