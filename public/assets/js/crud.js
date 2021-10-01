const BASE_URL = $('meta[name="_url"]').attr("content");
const PATH_URL = $('meta[name="_path"]').attr("content");
// Ajax Setup
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
    },
    // beforeSend: function() {
    //     loading()
    // },
    complete: function (xhr, stat) {
        closeLoading();
    },
    success: function (result, status, xhr) {
        closeLoading();
    },
});


// Remove Validation
const removeValidation = () => {
    $(".error-message").remove();
    $(".form-control").removeClass("is-invalid");
    $('.select2-selection--single').removeClass("is-valid").removeClass("is-invalid");
    $(".validation").removeClass("is-valid").removeClass("is-invalid");
    $(".provinsi").val("").change();
    $(".kota").val("");
    $("#form-store").trigger("reset");
};

// Remove and Add Validation
const removeAddValidation = () => {
    $(".error-message").remove();
    $(".form-control").removeClass("is-invalid");
    $('.select2-selection--single').removeClass("is-valid").removeClass("is-invalid");
    $(".validation").addClass("is-valid").removeClass("is-invalid");
};

// Show Loading Screen
const loading = () => {
    $.blockUI({
        baseZ: 2000,
        message: `<div class="spinner-border spinner-border-sm" role="status">
        <span class="sr-only">Loading...</span>
      </div> Loading...`,
        overlayCSS: {
            backgroundColor: "#fff",
            opacity: 0.8,
            cursor: "wait",
        },
        css: {
            border: 0,
            padding: "10px 15px",
            color: "#fff",
            backgroundColor: "#333",
        },
    });
};

// Close Loading Screen
const closeLoading = () => {
    $.unblockUI();
};

// Success Message
const successMessage = (message) => {
    alertify.success(message);
};

// Error Message
const errorMessage = (message) => {
    alertify.error(message);
};

const CleanUrl = () => {
    let url = window.location.href;
    let a = url.indexOf("?");
    if (a > 0) {
        let b = url.substring(a);
        let c = url.replace(b, "");
        url = c;
    }
    let final = url.replace("#", "");
    return final;
};

const CURRENT_URL = CleanUrl();

// Action Table in DataTable
const actionTable = (data, option = false, multiOption = null) => {
    return `
    <div class="btn-group">
        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-list"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="">
        ${option == true
            ? `<a class="dropdown-item d-flex align-items-center detailData mb-2" data-id="${data}"  href="${CURRENT_URL}/${data}">
                <i class="icon-magnifier icon-action"></i>
                 <span class=" ml-3">Detail</span>
              </a>`
            : ""
        }
        ${multiOption ?? ''}
        <a class="dropdown-item mb-2 d-flex align-items-center editData" data-id="${data}">
            <i class="icon-pencil icon-action"></i>
            <span class=" ml-3">Edit</span>
            </a>

            <a class="dropdown-item mb-2 d-flex align-items-center deleteData" data-id="${data}" href="#">
            <i class="icon-trash-bin icon-action"></i>
            <span class=" ml-3">Hapus</span></a>
            </div>
        </div>
    </div>
    `;
};

// Multi Reload
const multiReload = (multiReloadOption) => {
    if (multiReloadOption.length > 0) {
        $.each(multiReloadOption, function (key, value) {
            DTReload(value);
        });
    }
};

const DTReload = (table = "table") => {
    $("#" + table)
        .DataTable()
        .ajax.reload();
};

const MDHide = (modal = "modal-store") => {
    $("#" + modal).modal("hide");
    $('.modal-backdrop').remove();
};

// Show Modal
const MDShow = (modal = "modal-store") => {
    $("#" + modal).modal("show");
};

// Generate Data Table
const generateTable = (args) => {
    let defaults = {
        table: "table",
        url: CURRENT_URL,
        column: [],
        pageLength: 10,
        lengthChange: true,
        optional: [

        ]
    };

    args = $.extend({}, defaults, args);

    let DataTable = $("#" + args.table).DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: args.url,
        destroy: true,
        lengthChange: args.lengthChange,
        pageLength: args.pageLength,
        columns: args.column,
    });

    if (args.optional.length > 0) {
        DataTable.on('xhr', function () {
            let ajaxJson = DataTable.ajax.json();
            $.each(args.optional, function (key, value) {
                if (value.type == 'number') {
                    $(`#${value.id}`).html(value.text + ' ' + ajaxJson[value.name] ?? 0);
                }
                else {
                    $(`#${value.id}`).html(value.text + ' ' + ajaxJson[value.name] ?? '-');
                }
            })
        });
    }

    return DataTable;
};
// Ajax Post Data
const ajaxPostData = (
    url,
    data,
    modal,
    table,
    redirect,
    location,
    multiReloadOption,
    callFunction = []
) => {
    $.ajax({
        async: true,
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        async: true,
        url: url,
        data: data,
        beforeSend: function (request) {
            loading();
            removeAddValidation();
        },
        success: function (data) {
            closeLoading();
            if (data.status == true) {
                successMessage(data.message);
                if (redirect == true) {
                    window.location = location;
                }

                if (callFunction.length > 0) {
                    $.each(callFunction, function (key, value) {
                        setTimeout(() => {
                            value.function();
                        }, value.time);
                    })
                }
            } else {
                errorMessage(data.message);
            }
            MDHide(modal);
            DTReload(table);
            multiReload(multiReloadOption);
        },
        error: function (error) {
            closeLoading();
            var res = error.responseJSON;
            if (error.status == 422) {
                $.each(res.errors, function (key, value) {
                    $("#" + key)
                        .find("input")
                        .addClass("is-invalid")
                        .removeClass("is-valid");
                    $("#" + key)
                        .find("select")
                        .addClass("is-invalid")
                        .removeClass("is-valid");
                    $("#" + key)
                        .find("textarea")
                        .addClass("is-invalid")
                        .removeClass("is-valid");
                    $("#" + key)
                        .find(".select2-selection--single")
                        .addClass("is-invalid")
                        .removeClass("is-valid");

                    $("#" + key)
                        .find(".dropify-wrapper")
                        .addClass("is-invalid")
                        .removeClass("is-valid");

                    // $("#"+key).append(`<small class="text-danger error-message">${value}</small>`);
                    $(`div[id="${key}"]`).append(
                        `<small class="text-danger error-message">${value}</small>`
                    );
                });
            } else {
                errorMessage("Server Error");
                $("#" + modal).modal("hide");
            }
        },
    });
};

// Full Crud
const CRUD = {
    // Store Data
    storeData: function (args = null) {
        let defaults = {
            url: CURRENT_URL,
            form: "form-store",
            modal: "modal-store",
            table: "table",
            redirect: false,
            location: null,
            multiReload: false,
            multiReloadOption: [],
            optional: [],
            callFunction: [],
        };

        args = $.extend({}, defaults, args);

        $("#" + args.form).on("submit", function (e) {
            e.preventDefault();
            let data = new FormData(this);
            ajaxPostData(
                args.url,
                data,
                args.modal,
                args.table,
                args.redirect,
                args.location,
                args.multiReloadOption,
                args.callFunction
            );
        });
    },

    addButton: function (args = null) {
        let defaults = {
            id: "btn-add",
            form: "form-store",
            modal: "modal-store",
            title: "Tambah Data",
            defaultPrimary: "id",
            optional: [],
            outletKode: false,
        };

        args = $.extend({}, defaults, args);

        $("#" + args.id).on("click", function () {
            $("#" + args.form).trigger("reset");
            $("#" + args.defaultPrimary).val("");
            if (args.defaultPrimary != 'id') {
                $("#" + args.defaultPrimary + "_lama").val("");
            }
            $("#" + args.modal).modal("show");
            $("#modal-title").html(args.title);
            $("#method").val("POST");
            if (args.optional.length > 0) {
                $.each(args.optional, function (keyOptional, valueOptional) {
                    $(`#${valueOptional.name}_lama`).val("");
                    $("#" + valueOptional.name).html(
                        `<label>${valueOptional.title}</label><input type="file" name="${valueOptional.name}" class="border"/>`
                    );
                    $(`#${valueOptional.name} input`).dropify();
                });
            }

            if (args.outletKode == true) {
                getOutlet("outlet");
            }
            removeValidation();
        });
    },

    editData: function (args = null) {
        let defaults = {
            table: "table",
            button: "editData",
            modal: "modal-store",
            defaultPrimary: "id",
            url: CURRENT_URL,
            title: "Edit Data",
            redirect: false,
            outletKode: false,
            useUrlEdit: true,
            optionalSelect: [
                // {
                //     name: 'produk',
                //     name2 : 'harga
                // }
            ],
            optional: [
                // {
                //     name : 'gambar',
                //     title : 'Gambar',
                //     pathImage : 'localhost:8000/assets/storage/',
                // }
            ],
            optionalFile: [],
        };

        args = $.extend({}, defaults, args);

        $("#" + args.table).on("click", "." + args.button, function (e) {
            $("#method").val("PUT");
            $("#modal-title").html(args.title);
            removeValidation();

            let id = $(this).data("id");
            let urlEdit = '';
            if (args.useUrlEdit == true) {
                urlEdit = args.url + "/" + id + "/edit";
            }
            else {
                urlEdit = args.url + "/" + id;
            }

            if (args.redirect == true) {
                window.location = urlEdit;
            }
            else {
                $.get(urlEdit, function (result) {
                    $.each(result, function (key, value) {
                        if (key == args.defaultPrimary) {
                            $("#" + args.defaultPrimary).val(value);
                            $("#" + args.defaultPrimary + "_lama").val(value);
                        }

                        if (key != "password") {
                            $(`#${key} input[type="text"]`).val(value);
                            $(`#${key} input[type="hidden"]`).val(value);
                            $(`#${key} input .number`).val(value).trigger("input");
                            $(`#${key} input[type="number"]`).val(value);
                            $(`#${key} input[type="date"]`).val(value);
                            $(`#${key} input[type="time"]`).val(value);
                            $(`#${key} textarea`).val(value);
                            $(`div[id="${key}"] textarea`).val(value);
                        }

                        if (args.optionalSelect.length > 0) {
                            $.each(args.optionalSelect, function (keySelect, valueSelect) {
                                if (valueSelect.name == key) {
                                    $(`#${key} select`).select2("trigger", "select", {
                                        data: { id: result.produk_kode, text: result.produk_kode + ' - ' + value, harga: result.harga }
                                    });
                                    setTimeout(() => {
                                        $(`#${key} select`).val(result.produk_kode).trigger("change");
                                    }, 1500);
                                }
                            })
                        }
                        else {
                            $(`#${key} select`).val(value).trigger("change");
                        }

                        if (args.optional.length > 0) {
                            $.each(
                                args.optional,
                                function (keyOptional, valueOptional) {
                                    if (valueOptional.name == key) {
                                        $("#" + valueOptional.name).html(
                                            `<label>${valueOptional.title
                                            }</label><input type="file" name="${valueOptional.name
                                            }" class="border" data-default-file="${valueOptional.pathImage + value
                                            }" />`
                                        );
                                        $(`#${valueOptional.name}_lama`).val(value);
                                        $(`#${valueOptional.name} input`).dropify();
                                    }
                                }
                            );
                        }

                        if (args.optionalFile.length > 0) {
                            $.each(
                                args.optionalFile,
                                function (keyOptionalFile, valueOptionalFile) {
                                    if (key == valueOptionalFile.name) {
                                        $("#" + valueOptionalFile.id).val(value);
                                    }
                                }
                            );
                        }

                        if (key.includes("_id") == true) {
                            let perubahan = key.replace("_id", "");
                            $(`#${perubahan} select`).val(value).change();
                        }

                        if (key == "kota_id") {
                            setTimeout(() => {
                                $(`#kota select`)
                                    .val(value)
                                    .trigger("change");
                            }, 2000);
                        }

                        if (key == "tanggal_awal" || key == "tanggal_akhir" || key == "tanggal_selesai") {
                            let format = formatDateTimeLocal(value);
                            $(`#${key} input[type="datetime-local"]`).val(format);
                        }

                        if (key == "outlet_kode") {
                            getOutlet('outlet', value)

                            setTimeout(() => {
                                $(`#outlet select`)
                                    .val(value)
                                    .trigger("change");
                            }, 1500);
                        }

                        if (key == 'harga_turunan_with') {
                            let html = '';
                            if (value.length > 0) {
                                $.each(value, function (k, v) {
                                    html += `
                                    <div class="col-md-6">
                                        <label>${v.level.nama}</label>
                                        <input type="hidden" name="level_id[]" value="${v.level_id}">
                                        <input type="text" class="form-control validation number" name="harga_turunan[]" value="${v.harga}">
                                    </div>
                                    `
                                })
                            }
                            else {
                                $.each(result.level, function (k, v) {
                                    html += `
                                    <div class="col-md-6">
                                        <label>${v.nama}</label>
                                        <input type="hidden" name="level_id[]" value="${v.id}">
                                        <input type="text" class="form-control validation number" name="harga_turunan[]" value="">
                                    </div>
                                    `
                                })
                            }
                            $('#disini').html(html);
                        }
                    });

                    MDShow(args.modal);
                });
            }
        });
    },

    deleteData: function (args = null) {
        let defaults = {
            table: "table",
            button: "deleteData",
            modal: "modal-store",
            url: CURRENT_URL,
            confirmMessage: "Apakah yakin ingin menghapus data ini ?",
            multiReload: [],
        };

        args = $.extend({}, defaults, args);

        $("#" + args.table).on("click", "." + args.button, function (e) {
            let id = $(this).data("id");
            let urlDelete = args.url + "/" + id;
            let confir = confirm(args.confirmMessage);
            if (confir == true) {
                $.ajax({
                    type: "DELETE",
                    url: urlDelete,
                    success: function (data) {
                        successMessage(data.message);
                        DTReload(args.table);

                        multiReload(args.multiReload);
                    },
                    error: function (data) {
                        errorMessage("Server Error");
                    },
                });
            }
        });
    },
};

const convertCurrency = (angka, prepix = "Rp") => {
    if (angka == null || angka == "") {
        return prepix + "0";
    }
    let reverse = angka.toString().split("").reverse().join(""),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join(".").split("").reverse().join("");

    return prepix + " " + ribuan;
};

const clearNumber = number => {
    if (number == "") {
        return 0;
    } else {
        return number.replace(/\./g, "");
    }
};

const number = () => {
    $(".number").mask("000.000.000.000", {
        reverse: true
    });
};

$(document).ready(function () {
    $(document).on("focus", ".number", function () {
        number()
    });
    $('.dropify-init').dropify();
    number();

    $(".outlet-init").select2({
        placeholder: "Cari Outlet",
        // allowClear: true,
        theme: "bootstrap",
        // dropdownPosition: "below",
        ajax: {
            dataType: "json",
            type: "GET",
            url: BASE_URL + "/admin/ajax/get_outlet_all",
            data: function (params) {
                return {
                    search: params.term,
                };
            },
            processResults: function (data, page) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.kode + " - " + item.nama,
                            id: item.kode,
                        };
                    }),
                };
            },
        },
    });


    $(".produk").select2({
        placeholder: "Cari Produk",
        allowClear: true,
        theme: "bootstrap",
        // dropdownPosition: "below",
        ajax: {
            dataType: "json",
            type: "GET",
            url: BASE_URL + "/admin/ajax/get_produk_all",
            data: function (params) {
                return {
                    search: params.term,
                };
            },
            processResults: function (data, page) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.kode + " - " + item.nama,
                            id: item.kode,
                            harga: item.harga
                        };
                    }),
                };
            },
        },
    });

    $(".outlet").select2({
        theme: 'bootstrap'
    });
    $(".provinsi").select2({
        theme: 'bootstrap'
    });
    $(".kota").select2({
        theme: 'bootstrap'
    });


})

const formatDateTimeLocal = (dateTime) => {
    return moment(dateTime).format("YYYY-MM-DDTHH:mm:ss.000");
}

const getOutlet = (selector, outletKode = null) => {
    $.ajax({
        url: BASE_URL + "/admin/ajax/get_outlet_all",
        beforeSend: function () {
            $("#" + selector + " select").html(`<option value="">Loading..</option>`);
        },
        success: function (res) {
            $("#" + selector + " select").empty();
            $("#" + selector + " select").append(`<option value="">Pilih</option>`);
            for (let i = 0; i < res.length; i++) {
                $("#" + selector + " select").append(
                    $("<option>", {
                        value: res[i].kode,
                        text: res[i].nama
                    })
                );
            }
        }
    })
}

const getKota = (selector, provinsiID) => {
    $.ajax({
        url: BASE_URL + "/ajax/kota/" + provinsiID,
        beforeSend: function () {
            $(selector).html(`<option value="">Loading..</option>`);
        },
        success: function (res) {
            $(selector).empty();
            $(selector).append(`<option value="">Pilih</option>`);
            for (let i = 0; i < res.length; i++) {
                $(selector).append(
                    $("<option>", {
                        value: res[i].id,
                        text: res[i].kota
                    })
                );
            }
        }
    });
};

const randomString = (length = 10) => {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
}

$(".provinsi").on("change", function () {
    getKota(".kota", $(this).val());
});
