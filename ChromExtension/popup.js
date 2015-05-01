// Copyright (c) 2012 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

$(document).ready(function () {
    var console = chrome.extension.getBackgroundPage().console;


    var apiCall;
    if (window.location.href.indexOf("localhost") < 1) {
        apiCall = "http://localhost:2000/sites";
    } else {
        apiCall = "sitesaver.therealcarlos.com";
    }

    console.log("apiCall", apiCall);
    var tablink = "";
    chrome.tabs.getSelected(null, function (tab) {
        var tablink = tab.url;
        $('#url').val(tablink)
        //$('#currentUrl').text(tablink)
    });


    $('#formSites').submit(function (e) {
        /* Act on the event */

        e.preventDefault();


        var formData = $(this).serialize();


        $.ajax({
            url: apiCall + '/add',
            type: "POST",
            dataType: 'json',
            data: formData
        })
            .done(function (data) {
                console.log(data);
                if (data.Result) {
                    window.close();
                }
            })
            .fail(function () {
                console.log("error");
            })
            .always(function () {
                console.log("complete");
            });


    });

    $('#showSites').click(function (event) {
        $.getJSON(apiCall, function (data) {
            console.log(data);
            $('#sites ul').children('li').remove();
            $.each(data, function (index, obj) {
                $('#sites ul').append("<li>" + obj.url + "</li>")
            });
        });
    });

});



