jQuery((function(o){o("#rates_rows").sortable({items:"tr",cursor:"move",axis:"y",handle:".sort",scrollSensitivity:40,forcePlaceholderSize:!0,helper:"clone",opacity:.65,placeholder:"wc-metabox-sortable-placeholder",start(o,e){e.item.css("background-color","#f6f6f6")},stop(o,e){e.item.removeAttr("style")}}),o("#_wc_accommodation_booking_has_restricted_days").on("change",(function(){o(this).is(":checked")?o(".booking-day-restriction").show():o(".booking-day-restriction").hide()})),o("#_wc_accommodation_booking_has_restricted_days").trigger("change")}));