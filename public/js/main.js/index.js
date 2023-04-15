$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $("span#span-3").on("click", function () {
        $parent = $(this).closest(".cart-product-prices");
        $id = $parent
            .children("input")
            .map(function () {
                return $(this).val();
            })
            .get();

        $.ajax({
            url: "/Cart/delete",
            method: "POST",
            data: { MaSP: $id[0] },
            success: function (data) {
                location.reload();
                $("#cart").html(data);
            },
        });
    });
});

// order
$(document).ready(function () {
    $("#voucher").on("click", function () {
        $.ajax({
            url: "/Order/discountPage",
            method: "POST",
            success: function (data) {
                if (data == false) {
                    console.log("FA");
                    return false;
                }
                $(".serviec-body").html(data);
                $("#voucher").attr("id", "confirm");
                $("#address-num-2").addClass("active");

                $("#confirm").on("click", function () {
                    $.ajax({
                        url: "/Order/confirmPage",
                        method: "POST",
                        success: function (data) {
                            $(".serviec-body").html(data);
                            $("#address-num-3").addClass("active");
                            $("#confirm").html("Đặt Hàng");
                            $("#confirm").attr("id", "order");

                            $("#order").on("click", function () {
                                $.ajax({
                                    url: "Bill/store",
                                    method: "POST",
                                    success: function (data) {
                                        $(".serviec-body").html(
                                            "<a href='index.php'>Quay lại trang chủ </a>"
                                        );
                                        $(".cart-btn").html(data);
                                        $("#address-num-3").addClass("active");
                                    },
                                });
                            });
                        },
                    });
                });
            },
        });
    });

    $(window).resize(function () {
        console.log("ok");

        var windowWidth = $(window).width();
        if (windowWidth <= 1100) {
            $(window).scroll(function () {
                $(".header-search").css("top", "0");
                if ($(window).scrollTop() == 0) {
                    $(".header-search").css("top", "50px");
                }
            });
        }
    });
    $(window).scroll(function () {
        $(".app-header").css("top", "0");
        if ($(window).scrollTop() == 0) {
            $(".app-header").css("top", "30px");
        }
    });
    $(".btn.btn-back.disiable").on("click", function () {
        history.back();
    });

    //update address
    $("#btn-address").on("click", function () {
        $phone = $("input[name='phone']").val();
        $nation = $("input[name='nation']").val();
        $province = $("input[name='province']").val();
        $district = $("input[name='district']").val();
        $Wards = $("input[name='Wards']").val();
        $houseName = $("input[name='houseName']").val();
        $houseNumber = $("input[name='hosueNumber']").val();
        $way = $("input[name='way']").val();
        $id = $("input[name='id']").val();
        $.ajax({
            url: "?controller=user&action=update",
            method: "POST",
            data: {
                phone: $phone,
                nation: $nation,
                province: $province,
                district: $district,
                Wards: $Wards,
                houseName: $houseName,
                hosueNumber: $houseNumber,
                way: $way,
                id: $id,
            },
            success: function (data) {
                $(".address").html(data);
            },
        });
    });
    // show form edit
    $("button#showformedit").on("click", function () {
        $.ajax({
            url: "?controller=user&action=update",
            method: "POST",
            data: {
                option: "show",
            },
            success: function (data) {
                $(".address").html(data);
                $("#btn-address").on("click", function () {
                    $phone = $("input[name='phone']").val();
                    $nation = $("input[name='nation']").val();
                    $province = $("input[name='province']").val();
                    $district = $("input[name='district']").val();
                    $Wards = $("input[name='Wards']").val();
                    $houseName = $("input[name='houseName']").val();
                    $houseNumber = $("input[name='hosueNumber']").val();
                    $way = $("input[name='way']").val();
                    $id = $("input[name='id']").val();
                    $.ajax({
                        url: "?controller=user&action=update",
                        method: "POST",
                        data: {
                            phone: $phone,
                            nation: $nation,
                            province: $province,
                            district: $district,
                            Wards: $Wards,
                            houseName: $houseName,
                            hosueNumber: $houseNumber,
                            way: $way,
                            id: $id,
                        },
                        success: function (data) {
                            location.reload();
                            $(".address").html(data);
                        },
                    });
                });
            },
        });
    });

    // show detail bill
    $(".btn-detail").on("click", function () {
        $tr = $(this).closest("tr");

        var id = $tr
            .children("td#ID")
            .map(function () {
                return $(this).text();
            })
            .get();
        $.ajax({
            url: "?controller=bill&action=showDetail",
            method: "POST",
            data: {
                id: id,
                option: "user",
            },
            success: function (data) {
                $(".bill-container").html(data);

                $(".inc.btn-id").on("click", function () {
                    $parent = $(this).closest(".product-edit");
                    $id = $parent
                        .children("input")
                        .map(function () {
                            return $(this).val();
                        })
                        .get();
                    $idhd = $parent
                        .children("input.MaHD")
                        .map(function () {
                            return $(this).val();
                        })
                        .get();
                    $.ajax({
                        url: "?controller=bill&action=updateDetailBillForUser",
                        method: "POST",
                        data: {
                            MaSP: $id[0],
                            option: "inc",
                            MaHD: $idhd[0],
                        },
                        success: function (data) {
                            location.reload();
                            $(".bill-container").html(data);
                        },
                    });
                });

                $(".des.btn-id").on("click", function () {
                    $parent = $(this).closest(".product-edit");
                    $id = $parent
                        .children("input")
                        .map(function () {
                            return $(this).val();
                        })
                        .get();

                    $idhd = $parent
                        .children("input.MaHD")
                        .map(function () {
                            return $(this).val();
                        })
                        .get();
                    $.ajax({
                        url: "?controller=bill&action=updateDetailBillForUser",
                        method: "POST",
                        data: {
                            MaSP: $id[0],
                            option: "des",
                            MaHD: $idhd[0],
                        },
                        success: function (data) {
                            location.reload();
                            $(".bill-container").html(data);
                        },
                    });
                });
                $("i.fas.fa-trash-alt").on("click", function () {
                    $parent = $(this).closest(".product-right");
                    $id = $parent
                        .children("input")
                        .map(function () {
                            return $(this).val();
                        })
                        .get();
                    $idhd = $parent
                        .children("input.MaHD")
                        .map(function () {
                            return $(this).val();
                        })
                        .get();
                    $mount = $parent
                        .children("input.mount")
                        .map(function () {
                            return $(this).val();
                        })
                        .get();
                    $.ajax({
                        url: "?controller=bill&action=deleteDetailBillForUser",
                        method: "POST",
                        data: {
                            MaSP: $id[0],
                            option: "delete",
                            mount: $mount[0],
                            MaHD: $idhd[0],
                        },
                        success: function (data) {
                            location.reload();
                            $("#cart").html(data);
                        },
                    });
                });
            },
        });
    });
});
// const btn_close = document.querySelector('#close');
// btn_close.onclick = function () {
//     document.querySelector('.modal').style.display = "none";
// }

$(document).ready(function () {
    $("#close").on("click", function () {
        $(".modal").css("display", "none");
    });
    $(".des.btn-id").on("click", function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $parent = $(this).closest(".product-edit");
        $id = $parent
            .children("input")
            .map(function () {
                return $(this).val();
            })
            .get();

        $.ajax({
            url: "/Cart/update",
            method: "POST",
            data: { MaSP: $id[0], option: "des" },
            success: function (data) {
                location.reload();
                $(".cart-body-contain").html(data);
            },
        });
    });
    $(".inc.btn-id").on("click", function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $parent = $(this).closest(".product-edit");
        $id = $parent
            .children("input")
            .map(function () {
                return $(this).val();
            })
            .get();

        $.ajax({
            url: "/Cart/update",
            method: "POST",
            data: { MaSP: $id[0], option: "inc" },
            success: function (data) {
                location.reload();

                $(".cart-body-contain").html(data);
            },
        });
    });

    $("i.fas.fa-trash-alt").on("click", function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $parent = $(this).closest(".product-right");
        $id = $parent
            .children("input")
            .map(function () {
                return $(this).val();
            })
            .get();
        $.ajax({
            url: "/Cart/delete",
            method: "POST",
            data: { MaSP: $id[0], option: "car-form" },
            success: function (data) {
                location.reload();
                $(".cart-body-contain").html(data);
            },
        });
    });
});

const btn_submenu = document.querySelector("#info-user");
btn_submenu.onclick = function () {
    document.querySelector("#submenu-info").classList.toggle("turnOn");
};

function validateForm(formSelecter) {
    let formRules = {};
    function getParentElement(element, selector) {
        while (element.parentElement) {
            if (element.parentElement.matches(selector)) {
                return element.parentElement;
            }
            element = element.parentElement;
        }
    }
    let validateRules = {
        required: function (value) {
            return value ? undefined : "Vui lòng nhập trường này";
        },
        email: function (value) {
            let regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return regex.test(value) ? undefined : "Trường này phải là email";
        },
        min: function (min) {
            return function (value) {
                return value.length >= min
                    ? undefined
                    : `Vui lòng nhập ít nhất ${min}`;
            };
        },
    };
    let form = document.querySelector(formSelecter);
    if (form) {
        var inputs = document.querySelectorAll("[name][rules]");
        for (var input of inputs) {
            var rules = input.getAttribute("rules").split("|");
            for (var rule of rules) {
                var ruleInfo;
                var isRuleHasValue = rule.includes(":");

                if (isRuleHasValue) {
                    ruleInfo = rule.split(":");
                    rule = ruleInfo[0];
                }
                var ruleFunc = validateRules[rule];

                if (isRuleHasValue) {
                    ruleFunc = ruleFunc(ruleInfo[1]);
                }

                if (Array.isArray(formRules[input.name])) {
                    formRules[input.name].push(ruleFunc);
                } else {
                    formRules[input.name] = [ruleFunc];
                }
            }
            input.onblur = handelValidate;
            input.oninput = handelClear;
        }
        function handelValidate(event) {
            var rules = formRules[event.target.name];
            var errorMessage;
            for (var rule of rules) {
                errorMessage = rule(event.target.value);
                if (errorMessage) {
                    break;
                }
            }
            if (errorMessage) {
                var parentElement = getParentElement(
                    event.target,
                    ".group-input"
                );
                if (parentElement) {
                    var formMessage =
                        parentElement.querySelector(".errMassage");
                    formMessage.innerText = errorMessage;
                }
            }
            return !errorMessage;
        }
        function handelClear(event) {
            var parentElement = getParentElement(event.target, ".group-input");
            if (parentElement) {
                var formMessage = parentElement.querySelector(".errMassage");
                formMessage.innerText = "";
            }
        }
        form.onsubmit = function (event) {
            event.preventDefault();
            var inputs = document.querySelectorAll("[name][rules]");
            var isValid = true;
            for (var input of inputs) {
                if (!handelValidate({ target: input })) {
                    isValid = false;
                }
            }
            if (isValid) {
                form.submit();
            }
        };
    }
}
