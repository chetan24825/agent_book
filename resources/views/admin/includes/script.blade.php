<script src="{{ asset('panel/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('panel/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('panel/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('panel/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('panel/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('panel/js/app.js') }}"></script>
<script src="{{ asset('aizfiles/aiz-core.js') }}"></script>
@stack('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        AIZ.plugins.aizUppy();
    });
</script>



<script type="text/javascript">
    function detailsInfo(e) {
        $('#info-modal-content').html(
            '<div class="c-preloader text-center absolute-center"><i class="las la-spinner la-spin la-3x opacity-70"></i></div>'
        );
        var id = $(e).data('id')
        $('#info-modal').modal('show');
        $.post('{{ route('admin.uploaded-files.info') }}', {
            _token: AIZ.data.csrf,
            id: id
        }, function(data) {
            $('#info-modal-content').html(data);
        });
    }

    function copyUrl(e) {
        var url = $(e).data('url');
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(url).select();
        try {
            document.execCommand("copy");
            AIZ.plugins.notify('success', '{{ 'Link copied to clipboard' }}');
        } catch (err) {
            AIZ.plugins.notify('danger', '{{ 'Oops, unable to copy' }}');
        }
        $temp.remove();
    }

    function sort_uploads(el) {
        $('#sort_uploads').submit();
    }
</script>
