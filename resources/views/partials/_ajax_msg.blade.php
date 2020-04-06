
@if(isset($success_msg) && !empty($success_msg))
	 <div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     {{ $success_msg }}
  </div>
@endif

@if(isset($error_msg) && !empty($error_msg))
 <div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     {{ $error_msg }}
  </div>
@endif

<script type="text/javascript">
  $(function () {
    $('.alert-dismissable').slideDown('slow', function () {
        $(this).delay(10000).fadeOut('slow', function () {
            $(this).remove();
        });
    });
  });
</script>