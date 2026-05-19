import "./bootstrap";
import "laravel-datatables-vite";
import "select2";
import Swal from "sweetalert2";

import {
    ClassicEditor,
    Essentials,
    Bold,
    Italic,
    Font,
    Paragraph,
    SourceEditing,
} from "ckeditor5";

//role and permission nestedtree
$(function () {
    // Parent checkbox change - toggle child checkboxes
    $(".parent-checkbox").on("change", function () {
        const parentId = $(this).val();
        $('input.child-checkbox[data-parent-id="' + parentId + '"]').prop(
            "checked",
            $(this).prop("checked"),
        );
        updateSelectAllStatus();
    });

    // "Select All" checkbox functionality
    $("#select-all").on("change", function () {
        $(".parent-checkbox, .child-checkbox").prop(
            "checked",
            $(this).prop("checked"),
        );
    });

    // Update "Select All" checkbox based on individual selections
    function updateSelectAllStatus() {
        $("#select-all").prop(
            "checked",
            $(".parent-checkbox, .child-checkbox").length ===
                $(".parent-checkbox, .child-checkbox:checked").length,
        );
    }

    // Child checkbox change - update parent checkbox and "Select All"
    $(".child-checkbox").on("change", function () {
        const parentId = $(this).data("parent-id");
        const parentCheckbox = $(
            'input.parent-checkbox[value="' + parentId + '"]',
        );
        parentCheckbox.prop(
            "checked",
            $('input.child-checkbox[data-parent-id="' + parentId + '"]:checked')
                .length > 0,
        );
        updateSelectAllStatus();
    });

    // category code when "Select All" is clicked
    $("#allCategory").on("change", function () {
        $(".category-item").prop("checked", this.checked);
    });

    // when any single category is clicked
    $(".category-item").on("change", function () {
        const total = $(".category-item").length;
        const checked = $(".category-item:checked").length;

        // check/uncheck "Select All"
        $("#allCategory").prop("checked", total === checked);
    });
});

// Password Icons js start ---
$(".password-toggle-group .toggle-password-btn").on("click", function () {
    const $group = $(this).closest(".password-toggle-group");
    const $input = $group.find("input");
    const $icon = $(this).find("i");

    if ($input.attr("type") === "password") {
        $input.attr("type", "text");
        $icon.removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
    } else {
        $input.attr("type", "password");
        $icon.removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
    }
});

// Menu js end ----
$(".hamburg-icon").click(function () {
    $(".sidebar-menus .accordion-item .show").removeClass("show");
    $(".sidebar").toggleClass("sidebar-close");
    $(".main-content").toggleClass("fullWidth-screen");
});

if ($(".editor").length) {
    document.querySelectorAll(".editor").forEach((editorElement) => {
        ClassicEditor.create(editorElement, {
            licenseKey: "GPL",
            plugins: [Essentials, Bold, Italic, Font, Paragraph, SourceEditing],
            toolbar: [
                "undo",
                "redo",
                "|",
                "bold",
                "italic",
                "|",
                "fontSize",
                "fontFamily",
                "fontColor",
                "fontBackgroundColor",
                "|",
                "sourceEditing",
            ],
        })
            .then((newEditor) => {
                // Optional: Store editor instance if needed
                window.editors = window.editors || [];
                window.editors.push(newEditor);
            })
            .catch((error) => console.error(error));
    });

    // script for making a slug for page/
    $(".makeSlug").on("blur", function () {
        let title = $(this).val().trim();
        let slug = title
            .toLowerCase()
            .replace(/\s+/g, "-") // replace all spaces/tabs with "-"
            .replace(/[^\w-]+/g, "") // remove non-word chars except "-"
            .replace(/-+/g, "-"); // collapse multiple dashes
        console.log(slug);
        $(".pageSlug").val(slug);
    });
}

/**Sweet alert on delete button
 * code start */
$(document).on("click", ".delete-btn", function (event) {
    event.preventDefault();
    const form = $(this).closest("form");
    const actionUrl = form.attr("action");
    Swal.fire({
        title: delete_modal_title,
        text: delete_modal_text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: confirm_button_modal,
        cancelButtonText: cancel,
        confirmButtonColor: "",
        cancelButtonColor: "",
        customClass: {
            title: "delete-modal-title",
            icon: "warning-icon mt-0",
            confirmButton:
                "confirm-button-class border-primary btn btn-primary px-4 fw-semibold",
            cancelButton:
                "cancel-button-class px-4 btn btn-secondary fw-semibold",
            popup: "rounded-3 py-8",
        },
        didRender: function () {
            $(".swal2-html-container").addClass("py-2");
        },
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: actionUrl,
                type: "POST",
                data: form.serialize(),
                success: function (response) {
                    if (response.status == "success") {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your item has been deleted.",
                            icon: "success",
                            confirmButtonText: "ok",

                            customClass: {
                                title: "delete-modal-title text-secondary mt-0",
                                popup: "rounded-3 py-8",
                                confirmButton:
                                    "confirm-button-ok confirm-button-class border-primary btn btn-primary px-8 fw-semibold",
                                icon: "warning-icon-delete-modal mt-0",
                            },
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                },
            });
        }
    });
});
// Sweet alert on delete button code end

// ==========================================
// Generic Daterangepicker + DataTable Filter
// Reusable across any page with #filter-form, #apply-filter, #reset-filter, #daterange
// ==========================================
$(function () {
    // --- Daterangepicker setup (only if #daterange exists) ---
    if ($("#daterange").length > 0) {
        import("daterangepicker").then(() => {
            import("daterangepicker/daterangepicker.css");

            $("#daterange").daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: "Clear",
                    format: "YYYY-MM-DD",
                    separator: " to ",
                },
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [
                        moment().subtract(1, "days"),
                        moment().subtract(1, "days"),
                    ],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [
                        moment().startOf("month"),
                        moment().endOf("month"),
                    ],
                    "Last Month": [
                        moment().subtract(1, "month").startOf("month"),
                        moment().subtract(1, "month").endOf("month"),
                    ],
                },
            });

            $("#daterange").on("apply.daterangepicker", function (ev, picker) {
                $(this).val(
                    picker.startDate.format("YYYY-MM-DD") +
                        " to " +
                        picker.endDate.format("YYYY-MM-DD"),
                );
            });

            $("#daterange").on("cancel.daterangepicker", function (ev, picker) {
                $(this).val("");
            });
        });
    }

    // --- Generic DataTable filter (auto-detects the table) ---
    if ($("#filter-form").length === 0) return;

    // Find the first DataTable instance on the page
    let dataTable = null;
    let tableKeys = Object.keys(window.LaravelDataTables || {});
    if (tableKeys.length > 0) {
        dataTable = window.LaravelDataTables[tableKeys[0]];
    }

    if (!dataTable) return;

    // Collect all filter values from #filter-form by their name attribute
    function getFilters() {
        let filters = {};
        $("#filter-form")
            .find("select, input")
            .each(function () {
                let name = $(this).attr("name");
                let value = $(this).val();
                if (name && value) {
                    filters[name] = value;
                }
            });
        return filters;
    }

    // Attach filter data to every DataTable AJAX request
    dataTable.on("preXhr.dt", function (e, settings, data) {
        data.filters = getFilters();
    });

    // Apply filters
    $("#apply-filter").on("click", function () {
        dataTable.ajax.reload();
    });

    // Reset filters
    $("#reset-filter").on("click", function () {
        $("#filter-form")[0].reset();
        $("#daterange").val("");
        dataTable.ajax.reload();
    });
});
