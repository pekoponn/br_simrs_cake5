var handleGritterNotification = function () {
    function setFlash(titleFlash, textFlash) {
       // setTimeout(function(){
            //$.gritter.add({title:'Welcome back, Admin!',text:'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus lacus ut lectus rutrum placerat.',image:'../assets/img/user/user-12.jpg',sticky:true,time:'',class_name:'my-sticky-class'});
            $.gritter.add({title:titleFlash,text:textFlash});
            return !1;
        //    }, 500);
        //return false;
    }

    $("#remove-all-with-callbacks").click(function () {
        $.gritter.removeAll({
            before_close: function (e) {
                alert("I am called before all notifications are closed.  I am passed the jQuery object containing all  of Gritter notifications.\n" + e);
            },
            after_close: function () {
                alert("I am called after everything has been closed.");
            },
        });
        return !1;
    });
};
var handleSweetNotification = function () {
    $('[data-click="swal-primary"]').click(function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            icon: "info",
            buttons: { cancel: { text: "Cancel", value: null, visible: !0, className: "btn btn-default", closeModal: !0 }, confirm: { text: "Primary", value: !0, visible: !0, className: "btn btn-primary", closeModal: !0 } },
        });
    });
    $('[data-click="swal-info"]').click(function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            icon: "info",
            buttons: { cancel: { text: "Cancel", value: null, visible: !0, className: "btn btn-default", closeModal: !0 }, confirm: { text: "Info", value: !0, visible: !0, className: "btn btn-info", closeModal: !0 } },
        });
    });
    $('[data-click="swal-success"]').click(function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            icon: "success",
            buttons: { cancel: { text: "Cancel", value: null, visible: !0, className: "btn btn-default", closeModal: !0 }, confirm: { text: "Success", value: !0, visible: !0, className: "btn btn-success", closeModal: !0 } },
        });
    });
    $('[data-click="swal-warning"]').click(function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: { cancel: { text: "Cancel", value: null, visible: !0, className: "btn btn-default", closeModal: !0 }, confirm: { text: "Warning", value: !0, visible: !0, className: "btn btn-warning", closeModal: !0 } },
        });
    });
    $('[data-click="swal-danger"]').click(function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            icon: "error",
            buttons: { cancel: { text: "Cancel", value: null, visible: !0, className: "btn btn-default", closeModal: !0 }, confirm: { text: "Warning", value: !0, visible: !0, className: "btn btn-danger", closeModal: !0 } },
        });
    });
};
var Notification = (function () {
    "use strict";
    return {
        init: function () {
            handleGritterNotification();
            handleSweetNotification();
        },
    };
})();
$(document).ready(function () {
    Notification.init();
});