$(document).ready(function () {
    function load_data(url, page, column = "ID", byOrder = "asc") {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: url,
            method: "POST",
            data: {
                page: page,
                column: column,
                byOrder: byOrder,
            },
            success: function (data) {
                $(".table-responsive").html(data);
            },
        });
    }

    $(".deleteBtn").on("click", function () {
        $("#deletemodal").modal("show");
        $tr = $(this).closest("tr");

        var data = $tr
            .children("td#ID")
            .map(function () {
                return $(this).text();
            })
            .get();

        var pageN = $("li.page-item.active").children().attr("page");
        console.log(pageN);

        var column = $("th.sortKey").attr("column");

        var byOder = $("th.sortKey").attr("byOder");
        console.log(column);
        console.log(byOder);
        $("input[name='column']").val(column);
        $('input[name="byOrder"]').val(byOder);
        $("#delete_id").val(data[0]);

        $("#pageNumber").val(pageN);
    });
});

$(document).ready(function () {
    $("#selectMenu").change(function () {
        let idSelect = $(this).val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: "/Admin/Product/select",
            method: "POST",
            data: { idSelect: idSelect },
            success: function (data) {
                $("#selectGroup").html(data);
            },
        });
    });
});

$(document).ready(function () {
    $("#category_statistical").change(function () {
        let idSelect = $(this).val();
        $.ajax({
            url: "?controller=admin&action=statistical",
            method: "POST",
            data: { idSelect: idSelect },
            success: function (data) {
                $("#table_statistical").html(data);
            },
        });
    });
});

$(document).ready(function () {
    $("#add_temp").on("click", function () {
        let MaSP = $("#MaSP").val();
        let Mount = $("#mount").val();
        let Price = $("#price").val();
        let Name = $("#name").val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: "/Admin/Import/addImportTemp",
            method: "POST",
            data: {
                MaSP: MaSP,
                Mount: Mount,
                Price: Price,
                Name: Name,
            },
            success: function (data) {
                $("#loadImportDetail").html(data);
            },
        });
    });
});
$(document).ready(function () {
    $("button.edit-btn-import").on("click", function () {
        alert("ok");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        alert("ị");
        $.ajax({
            url: "/Admin/Import/updateDetailImport",
            method: "POST",
            data: {
                MaSP: MaSP,
                Mount: Mount,
                Price: Price,
                Name: Name,
            },
            success: function (data) {
                $("#loadImportDetail").html(data);
            },
        });
    });
});
$(document).ready(function () {
    $("div#importDetail").on("click", function () {
        $tr = $(this).closest("tr");

        var id = $tr
            .children("td#ID")
            .map(function () {
                return $(this).text();
            })
            .get();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        console.log("ok");
        $.ajax({
            url: "/Admin/Import/showDetail",
            method: "POST",
            data: { id: id },
            success: function (data) {
                $(".card.shadow.mb-4").html(data);
            },
        });
    });
});

$(document).ready(function () {
    $("div#billDetail").on("click", function () {
        $tr = $(this).closest("tr");

        var id = $tr
            .children("td#ID")
            .map(function () {
                return $(this).text();
            })
            .get();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: "/Bill/showDetail",
            method: "POST",
            data: { id: id },
            success: function (data) {
                $(".card.shadow.mb-4").html(data);
            },
        });
    });
});

$(document).ready(function () {
    $("div#edit_btn").on("click", function () {
        $tr = $(this).closest("tr");

        var id = $tr
            .children("td#ID")
            .map(function () {
                return $(this).text();
            })
            .get();
        var MaPN = $("input#IDPN").val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: "/Admin/Import/showFormImportDetail",
            method: "POST",
            data: { MaSP: id, MaPN: MaPN },
            success: function (data) {
                $("#formEditDetailImport").html(data);
            },
        });
    });

    $("#edit_btn_bill").on("click", function () {
        $tr = $(this).closest("tr");

        var id = $tr
            .children("td#ID")
            .map(function () {
                return $(this).text();
            })
            .get();
        var MaHD = $("input#IDHD").val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: "/Admin/Bill/showFormBillDetail",
            method: "POST",
            data: { MaSP: id, MaHD: MaHD },
            success: function (data) {
                console.log(data);
                $("#formEditDetailBill").html(data);
            },
        });
    });
});

// Validate

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
        numberCheck: function (value) {
            return value >= 0 ? undefined : "Vui lòng nhập số dương";
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
                    ".form-group"
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
            var parentElement = getParentElement(event.target, ".form-group");
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

validateForm("#menu_form");

validateForm("#menu_form_show");

validateForm("#author_form");

validateForm("#author_form_show");

validateForm("#category_form");

validateForm("#category_form_show");

validateForm("#product_form");

validateForm("#product_form_show");

validateForm("#promotion_form");

validateForm("#promotion_form_show");

validateForm("#publisher_form");

validateForm("#publisher_form_show");

validateForm("#supplisher_form");

validateForm("#supplisher_form_show");

validateForm("#import_form");

validateForm("#import_form_show");

validateForm("#detail_import_form");

validateForm("#statistical-two");

// arrayIDForm.map((form, index) => {
//     return validateForm(form);
// });

function loadNotification() {
    $(document).ready(function () {
        $(".toast").toast("show");
    });
}
