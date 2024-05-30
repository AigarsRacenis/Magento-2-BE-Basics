require(['jquery'], function ($,maxQty) {
    $(document).ready(function () {
        const maxQty = $('input.qty').data('max-qty');

        $('.qty-decrease').on('click', function () {
            const $input = $(this).siblings('input.qty');
            const value = parseInt($input.val(), 10);
            if (value > 1) {
                $input.val(value - 1);
            }
        });

        $('.qty-increase').on('click', function () {
            const $input = $(this).siblings('input.qty');
            const value = parseInt($input.val(), 10);
            if (value < maxQty) {
                $input.val(value + 1);
            }
        });
    });
});
