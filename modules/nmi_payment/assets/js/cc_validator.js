/*
   If a credit card number is invalid, an error reason is loaded into the global ccErrorNo variable. 
   This can be be used to index into the global error  string array to report the reason to the user 
   if required:
   
   e.g. if (!checkCreditCard (number, name) alert (ccErrors(ccErrorNo);
*/

var ccErrorNo = 0;
var ccErrors = new Array()

ccErrors[0] = "Unknown card type";
ccErrors[1] = "No card number provided";
ccErrors[2] = "Card number is in invalid format";
ccErrors[3] = "Card number is invalid";
ccErrors[4] = "Card number has an inappropriate number of digits";
ccErrors[5] = "Warning! This credit card number is associated with a scam attempt";

function checkCreditCard(cardnumber, cardname) {

    // Array to hold the permitted card characteristics
    var cards = new Array();

    // Define the cards we support. You may add addtional card types as follows.

    //  Name:         As in the selection box of the form - must be same as user's
    //  Length:       List of possible valid lengths of the card number for the card
    //  prefixes:     List of possible prefixes for the card
    //  checkdigit:   Boolean to say whether there is a check digit

    cards[0] = {
        name: "Visa",
        length: "13,16",
        prefixes: "4",
        checkdigit: true
    };
    cards[1] = {
        name: "MasterCard",
        length: "16",
        prefixes: "22,23,24,25,26,27,51,52,53,54,55",
        checkdigit: true
    };
    cards[2] = {
        name: "DinersClub",
        length: "14,16",
        prefixes: "36,38,54,55",
        checkdigit: true
    };
    cards[3] = {
        name: "CarteBlanche",
        length: "14",
        prefixes: "300,301,302,303,304,305",
        checkdigit: true
    };
    cards[4] = {
        name: "AmEx",
        length: "15",
        prefixes: "34,37",
        checkdigit: true
    };
    cards[5] = {
        name: "Discover",
        length: "16",
        prefixes: "6011,622,64,65",
        checkdigit: true
    };
    cards[6] = {
        name: "JCB",
        length: "16",
        prefixes: "35",
        checkdigit: true
    };
    cards[7] = {
        name: "enRoute",
        length: "15",
        prefixes: "2014,2149",
        checkdigit: true
    };
    cards[8] = {
        name: "Solo",
        length: "16,18,19",
        prefixes: "6334,6767",
        checkdigit: true
    };
    cards[9] = {
        name: "Switch",
        length: "16,18,19",
        prefixes: "4903,4905,4911,4936,564182,633110,6333,6759",
        checkdigit: true
    };
    cards[10] = {
        name: "Maestro",
        length: "12,13,14,15,16,18,19",
        prefixes: "5018,5020,5038,6304,6759,6761,6762,6763",
        checkdigit: true
    };
    cards[11] = {
        name: "VisaElectron",
        length: "16",
        prefixes: "4026,417500,4508,4844,4913,4917",
        checkdigit: true
    };
    cards[12] = {
        name: "LaserCard",
        length: "16,17,18,19",
        prefixes: "6304,6706,6771,6709",
        checkdigit: true
    };

    // Establish card type
    var cardType = -1;
    for (var i = 0; i < cards.length; i++) {

        // See if it is this card (ignoring the case of the string)
        if (cardname.toLowerCase() == cards[i].name.toLowerCase()) {
            cardType = i;
            break;
        }
    }

    // If card type not found, report an error
    if (cardType == -1) {
        ccErrorNo = 0;
        return false;
    }

    // Ensure that the user has provided a credit card number
    if (cardnumber.length == 0) {
        ccErrorNo = 1;
        return false;
    }

    // Now remove any spaces from the credit card number
    cardnumber = cardnumber.replace(/\s/g, "");

    // Check that the number is numeric
    var cardNo = cardnumber
    var cardexp = /^[0-9]{13,19}$/;
    if (!cardexp.exec(cardNo)) {
        ccErrorNo = 2;
        return false;
    }

    // Now check the modulus 10 check digit - if required
    if (cards[cardType].checkdigit) {
        var checksum = 0;                                  // running checksum total
        var mychar = "";                                   // next char to process
        var j = 1;                                         // takes value of 1 or 2

        // Process each digit one by one starting at the right
        var calc;
        for (i = cardNo.length - 1; i >= 0; i--) {

            // Extract the next digit and multiply by 1 or 2 on alternative digits.
            calc = Number(cardNo.charAt(i)) * j;

            // If the result is in two digits add 1 to the checksum total
            if (calc > 9) {
                checksum = checksum + 1;
                calc = calc - 10;
            }

            // Add the units element to the checksum total
            checksum = checksum + calc;

            // Switch the value of j
            if (j == 1) { j = 2 } else { j = 1 };
        }

        // All done - if checksum is divisible by 10, it is a valid modulus 10.
        // If not, report an error.
        if (checksum % 10 != 0) {
            ccErrorNo = 3;
            return false;
        }
    }

    // Check it's not a spam number
    if (cardNo == '5490997771092064') {
        ccErrorNo = 5;
        return false;
    }

    // The following are the card-specific checks we undertake.
    var LengthValid = false;
    var PrefixValid = false;
    var undefined;

    // We use these for holding the valid lengths and prefixes of a card type
    var prefix = new Array();
    var lengths = new Array();

    // Load an array with the valid prefixes for this card
    prefix = cards[cardType].prefixes.split(",");

    // Now see if any of them match what we have in the card number
    for (i = 0; i < prefix.length; i++) {
        var exp = new RegExp("^" + prefix[i]);
        if (exp.test(cardNo)) PrefixValid = true;
    }

    // If it isn't a valid prefix there's no point at looking at the length
    if (!PrefixValid) {
        ccErrorNo = 3;
        return false;
    }

    // See if the length is valid for this card
    lengths = cards[cardType].length.split(",");
    for (j = 0; j < lengths.length; j++) {
        if (cardNo.length == lengths[j]) LengthValid = true;
    }

    // See if all is OK by seeing if the length was valid. We only check the length if all else was 
    // hunky dory.
    if (!LengthValid) {
        ccErrorNo = 4;
        return false;
    };

    // The credit card is in the required format.
    return true;
}

/*================================================================================================*/

function cc_type(cc) {
    let base_url = window.location.origin;
    let pathname = window.location.pathname;
    let second_url = pathname.split('/')[1] + '/modules/' + pathname.split('/')[2];
    cc.value = cc.value.replace(/\s/g, '');
    let amex = new RegExp('^3[47][0-9]{13}$');
    let visa = new RegExp('^4[0-9]{12}(?:[0-9]{3})?$');
    let cup1 = new RegExp('^62[0-9]{14}[0-9]*$');
    let cup2 = new RegExp('^81[0-9]{14}[0-9]*$');

    let mastercard = new RegExp('^5[1-5][0-9]{14}$');
    let mastercard2 = new RegExp('^2[2-7][0-9]{14}$');

    let disco1 = new RegExp('^6011[0-9]{12}[0-9]*$');
    let disco2 = new RegExp('^62[24568][0-9]{13}[0-9]*$');
    let disco3 = new RegExp('^6[45][0-9]{14}[0-9]*$');

    let diners = new RegExp('^3[0689][0-9]{12}[0-9]*$');
    let jcb = new RegExp('^35[0-9]{14}[0-9]*$');


    if (visa.test(cc.value)) {
        $(cc).attr('maxlength', '16');
        // $('#card_cvc').mask('000');
        $('#cvv').attr('maxlength', '3');
        return `<img src="${base_url + '/' + second_url}/assets/images/card_icons/visa.webp" style="height: 15px;" >`;

    }
    if (amex.test(cc.value)) {
        $(cc).attr('maxlength', '15');
        // $('#card_cvc').mask('0000');
        $('#cvv').attr('maxlength', '4');
        // return 'AmEx';
        return `<img src="${base_url + '/' + second_url}/assets/images/card_icons/amex.png" style="height: 25px;" >`;

    }
    if (mastercard.test(cc.value) || mastercard2.test(cc.value)) {
        $(cc).attr('maxlength', '16');
        // $('#card_cvc').mask('000');
        $('#cvv').attr('maxlength', '3');
        // return 'MasterCard';
        return `<img src="${base_url + '/' + second_url}/assets/images/card_icons/mastercard.jpg" style="height: 25px;" >`;

    }
    if (disco1.test(cc.value) || disco2.test(cc.value) || disco3.test(cc.value)) {
        // $('#card_cvc').mask('000');
        $(cc).attr('maxlength', '16');
        $('#cvv').attr('maxlength', '3');
        // return 'Discover';
        return `<img src="${base_url + '/' + second_url}/assets/images/card_icons/discover.png" style="height: 25px;" >`;
    }
    if (diners.test(cc.value)) {
        // $('#card_cvc').mask('000');
        $(cc).attr('maxlength', '14');
        $('#cvv').attr('maxlength', '3');
        // return 'DinersClub';
        return `<img src="${base_url + '/' + second_url}/assets/images/card_icons/diners_pay.png" style="height: 15px;" >`;
    }
    if (jcb.test(cc.value)) {
        // $('#card_cvc').mask('000');
        $(cc).attr('maxlength', '16');
        $('#cvv').attr('maxlength', '3');
        // return 'JCB';
        return `<img src="${base_url + '/' + second_url}/assets/images/card_icons/jcb.png" style="height: 25px;" >`;
    }
    if (cup1.test(cc.value) || cup2.test(cc).value) {
        // $('#card_cvc').mask('000');
        $(cc).attr('maxlength', '16');
        $('#cvv').attr('maxlength', '3');
        // return 'CHINA_UNION_PAY';
        return `<img src="${base_url + '/' + second_url}/assets/images/card_icons/union_pay.png" style="height: 25px;" >`;
    }
    return null;
}


function validate_cc(x) {
    // window.validate_cc = function validate_cc(x) {
    $(x).siblings('span.text-danger').html('');
    x.value = x.value.replace(/[^0-9]/g, '');
    let values = x.value.replace(/\s/g, '');

    if (x.value.length < 13) {
        $('.card_type_box').html('');
        $(x).css('border', '1px solid #182a5b');
        $(x).siblings('span.text-danger').html('');
        return;
    }
    let type = cc_type(x);

    if (type !== null && checkCreditCard(values, type) != null) {
        $(x).siblings('span.text-danger').html('');
        $(x).css('border', '1px solid #06AA6D');
        $('.card_type_box').html(type);
    } else {
        $(x).css('border', '1px solid #fe0000');
        $(x).siblings('span.text-danger').html(ccErrors[ccErrorNo]);
        $('.card_type_box').html("");
    }

}