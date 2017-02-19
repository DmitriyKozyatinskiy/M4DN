<form role="form"  method="POST" action="{{ url('/devices/delete') }}">
  {{ csrf_field() }}
  <input type="hidden" name="id" id="js-remove-device-id">
  <div class="text-right">
    <button type="button" class="btn btn-default">Cancel</button>
    <button type="submit" class="btn btn-warning">Remove</button>
  </div>
</form>

