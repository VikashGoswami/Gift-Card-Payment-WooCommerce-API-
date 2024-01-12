$('#gift_card_number').on('input', function () {

    var giftCardNumber = $('#gift_card_number').val();

    $.ajax({
        type: 'POST',
        url: '/payment', // Replace with your actual API endpoint
        data: { gift_card_number: giftCardNumber },
        success: function (response) {
            // Update the UI with the new balance
            $('#balance').text('Gift Card Balance: ' + response.balance);
        },
        error: function (error) {
            console.error('Error updating balance:', error);
        }
    });

});