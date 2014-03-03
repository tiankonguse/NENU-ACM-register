
<div id="message" class="modal hide fade" tabindex="-1" role="dialog"
	aria-labelledby="messageModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"
			aria-hidden="true">×</button>
		<h3 id="messageModalLabel">注意</h3>
	</div>
	<div class="modal-body">
		<p></p>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" data-dismiss="modal"
			aria-hidden="true">确定</button>
	</div>
</div>
</div>
<script>
function showMessage(message,cb){
	$message = $("#message");
	$message.find(".modal-body>p").text(message);
	$message.modal("show");
	$message.on("hide",cb);
}
</script>
<!-- Piwik -->
<!-- <script type="text/javascript"> -->
<!-- //  acm.nenu.edu.cn is down,so I commentaryit. -->
<!-- //   var _paq = _paq || []; -->
<!-- //   _paq.push(["trackPageView"]); -->
<!-- //   _paq.push(["enableLinkTracking"]); -->

<!-- //   (function() { -->
<!-- //     var u=(("https:" == document.location.protocol) ? "https" : "http") + "://acm.nenu.edu.cn/piwik/"; -->
<!-- //     _paq.push(["setTrackerUrl", u+"piwik.php"]); -->
<!-- //     _paq.push(["setSiteId", "1"]); -->
<!-- //     var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript"; -->
<!-- //     g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s); -->
<!-- //   })(); -->
<!-- </script> -->
<!-- End Piwik Code -->
<div id="push"></div>
</div>
<div id="footer">
	<div class="container">
		<p class="muted credit">
			&copy;2013 ~
			<script>document.write(new Date().getFullYear());</script>
			<a href="http://acm.nenu.edu.cn">NENU ACM</a>. Writtern by <a href="http://winguse.com">Winguse</a>
			and <a href="http://tiankonguse.com">Tiankong</a>.
		</p>
	</div>
</div>
<script src="js/bootstrap.js"></script>
</body>
</html>


