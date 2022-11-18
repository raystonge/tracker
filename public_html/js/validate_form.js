function TrimString(sInString) {
    sInString = sInString.replace(/^\s+/g, "");
    return sInString.replace(/\s+$/g, "");
}

function isEmailAddr(emailStr) {
    var checkTLD = 1;
    var knownDomsPat = /^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
    var emailPat = /^(.+)@(.+)$/;
    var specialChars = "\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
    var validChars = "\[^\\s" + specialChars + "\]";
    var quotedUser = "(\"[^\"]*\")";
    var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
    var atom = validChars + '+';
    var word = "(" + atom + "|" + quotedUser + ")";
    var userPat = new RegExp("^" + word + "(\\." + word + ")*$");
    var domainPat = new RegExp("^" + atom + "(\\." + atom + ")*$");
    var matchArray = emailStr.match(emailPat);
    if (matchArray == null) {
        return false;
    }
    var user = matchArray[1];
    var domain = matchArray[2];
    for (i = 0; i < user.length; i++) {
        if (user.charCodeAt(i) > 127) {
            return false;
        }
    }
    for (i = 0; i < domain.length; i++) {
        if (domain.charCodeAt(i) > 127) {
            return false;
        }
    }
    if (user.match(userPat) == null) {
        return false;
    }
    var IPArray = domain.match(ipDomainPat);
    if (IPArray != null) {
        for (var i = 1; i <= 4; i++) {
            if (IPArray[i] > 255) {
                return false;
            }
        }
        return true;
    }
    var atomPat = new RegExp("^" + atom + "$");
    var domArr = domain.split(".");
    var len = domArr.length;
    for (i = 0; i < len; i++) {
        if (domArr[i].search(atomPat) == -1) {
            return false;
        }
    }
    if (checkTLD && domArr[domArr.length - 1].length != 2 && domArr[domArr.length - 1].search(knownDomsPat) == -1) {
        return false;
    }
    if (len < 2) {
        return false;
    }
    return true;
}

function validRequired(formField, fieldLabel) {
    var result = true;
    formField.value = TrimString(formField.value);
    if (formField.value == "") {
        alert('Please enter a value for the "' + fieldLabel + '" field.');
        formField.focus();
        result = false;
    }
    return result;
}

function allDigits(str) {
    return inValidCharSet(str, "0123456789");
}

function inValidCharSet(str, charset) {
    var result = true;
    for (var i = 0; i < str.length; i++)
    if (charset.indexOf(str.substr(i, 1)) < 0) {
        result = false;
        break;
    }
    return result;
}

function validEmail(formField, fieldLabel, required) {
    var result = true;
    if (required && !validRequired(formField, fieldLabel)) result = false;
    if (result && ((formField.value.length < 3) || !isEmailAddr(formField.value))) {
        alert("Please enter a complete email address in the form: yourname@yourdomain.com");
        formField.focus();
        result = false;
    }
    return result;
}

function validNum(formField, fieldLabel, required) {
    var result = true;
    if (required && !validRequired(formField, fieldLabel)) result = false;
    if (result) {
        if (!allDigits(formField.value)) {
            alert('Please enter a number for the "' + fieldLabel + '" field.');
            formField.focus();
            result = false;
        }
    }
    return result;
}

function validInt(formField, fieldLabel, required) {
    var result = true;
    if (required && !validRequired(formField, fieldLabel)) result = false;
    if (result) {
        var num = parseInt(formField.value, 10);
        if (isNaN(num)) {
            alert('Please enter a number for the "' + fieldLabel + '" field.');
            formField.focus();
            result = false;
        }
    }
    return result;
}

function validSelectionInt(formField, fieldLabel, required) {
    var result = true;
    if (required && !validRequired(formField, fieldLabel)) result = false;
    if (result) {
        var num = parseInt(formField.value, 10);
        if (num <= 0) {
            alert('Please select "' + fieldLabel + '"');
            formField.focus();
            result = false;
        }
    }
    return result;
}

function validDate(formField, fieldLabel, required) {
    var result = true;
    if (required && !validRequired(formField, fieldLabel)) result = false;
    if (result) {
        var elems = formField.value.split("/");
        result = (elems.length == 3);
        if (result == 0) {
            elems = formField.value.split("-");
            result = (elems.length == 3);
        }
        if (result) {
            var month = parseInt(elems[1], 10);
            var day = parseInt(elems[2], 10);
            var year = parseInt(elems[0], 10);
            result = allDigits(elems[1]) && (month > 0) && (month < 13) && allDigits(elems[2]) && (day > 0) && (day < 32) && allDigits(elems[0]) && ((elems[2].length == 2) || (elems[2].length == 4));
        }
        if (!result) {
            alert('Please enter a date in the format CCYY/MM/DD for the "' + fieldLabel + '" field.');
            formField.focus();
        }
    }
    return result;
}

function validatePhone(formField, fieldLabel, required) {
    if (required) {
        if (!validRequired(formField, fieldLabel)) result = false;
    }
    if (formField.value.length == 0) {
        return true;
    }
    if (formField.value.search(/\d{3}\-\d{3}\-\d{4}/) == -1) {
        alert('Please enter a phone number with the format xxx-xxx-xxxx for the "' + fieldLabel + '" field.');
        formField.focus();
        return false;
    }
    return true;
}