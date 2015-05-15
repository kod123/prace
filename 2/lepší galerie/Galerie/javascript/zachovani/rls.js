/*  RLS 1.0 - Remember in Local Storage
    Copyright © Michal A. Valasek - Altairis, 2011
    www.altairis.cz | www.aspnet.cz | www.rider.cz
--------------------------------------------------------------------------------
This script remembers values of selected input fields in LocalStorage. Usage:
1. Mark fields to remember with data-rls-id attribute with value setting the
   key to be used, ie.:
   <input type="text" name="firstName" data-rls-id="firstName" />
2. Clear the remembered fields by adding data-rls-clear attribute to any
   element on the page (most likely the form submit confirmation). Separate
   multiple keys with comma:
   <p data-rls-clear="firstName,lastName">Your form was submitted.</p>
*/
/// <reference path="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js" />

$(function () {
    // Check if this browser supports local storage
    if ("localStorage" in window && window["localStorage"] !== null) {

        // Clear all remembered entries required by data-rls-clear
        $("*[data-rls-clear]").each(function () {
            var fields = $(this).data("rls-clear").split(",");
            for (var i = 0; i < fields.length; i++) {
                window.localStorage.removeItem("RLS[" + fields[i].trim() + "]");
            }
        });

        $("*[data-rls-id]").each(function () {
            // Load currently remembered data
            var keyName = "RLS[" + $(this).data("rls-id") + "]";
            $(this).val(window.localStorage[keyName]);

            // Save data to local storage when value changes
            $(this).keyup(function () {
                window.localStorage[keyName] = $(this).val();
            });
        });

    }
});