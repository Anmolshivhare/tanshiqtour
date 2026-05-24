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


// Generic slug auto-generation
$(function () {
    const toSlug = (value) =>
        value
            .toString()
            .trim()
            .toLowerCase()
            .replace(/[^\w\s-]+/g, "")
            .replace(/\s+/g, "-")
            .replace(/-+/g, "-");

    if (!$(".makeSlug").length || !$(".pageSlug").length) return;

    $(".makeSlug").on("input blur", function () {
        $(".pageSlug").val(toSlug($(this).val() || ""));
    });

    if (!$(".pageSlug").val() && $(".makeSlug").val()) {
        $(".pageSlug").val(toSlug($(".makeSlug").val()));
    }
});

// Tour itinerary add/remove days
$(function () {
    const $container = $("#itinerary-container");
    const $addBtn = $("#add-day-btn");
    if (!$container.length || !$addBtn.length) return;

    const dayCardTemplate = (index, dayNumber) => `
        <div class="itinerary-day card mb-3 p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Day ${dayNumber}</h6>
                <button type="button" class="btn btn-outline-danger btn-sm remove-day-btn">Remove</button>
            </div>
            <input type="hidden" name="itinerary[${index}][day_number]" value="${dayNumber}">
            <div class="row g-2">
                <div class="col-md-6"><input type="text" name="itinerary[${index}][title]" class="form-control" placeholder="Day title"></div>
                <div class="col-md-6"><input type="text" name="itinerary[${index}][accommodation]" class="form-control" placeholder="Accommodation"></div>
                <div class="col-md-6"><input type="text" name="itinerary[${index}][meals_included]" class="form-control" placeholder="Meals (B/L/D)"></div>
                <div class="col-12"><textarea name="itinerary[${index}][description]" class="form-control" rows="2" placeholder="Day description"></textarea></div>
            </div>
        </div>`;

    function ensureRemoveButtons() {
        $container.find(".itinerary-day").each(function () {
            const $card = $(this);
            const $heading = $card.find("h6").first();
            if (!$card.find(".remove-day-btn").length) {
                if (!$heading.parent().hasClass("d-flex")) {
                    $heading.wrap('<div class="d-flex justify-content-between align-items-center mb-2"></div>');
                }
                $heading.after('<button type="button" class="btn btn-outline-danger btn-sm remove-day-btn">Remove</button>');
            }
        });
    }

    function reindexDays() {
        $container.find(".itinerary-day").each(function (index) {
            const dayNumber = index + 1;
            const $card = $(this);
            $card.find("h6").first().text(`Day ${dayNumber}`);

            $card.find("input, textarea, select").each(function () {
                const $field = $(this);
                const fieldName = $field.attr("name");
                if (!fieldName) return;
                $field.attr("name", fieldName.replace(/itinerary\[\d+\]/, `itinerary[${index}]`));
            });

            const $dayNumberField = $card.find('input[name^="itinerary["][name$="[day_number]"]').first();
            if ($dayNumberField.length) {
                $dayNumberField.val(dayNumber);
            }
        });
    }

    ensureRemoveButtons();
    reindexDays();

    $addBtn.on("click", function () {
        const dayNumber = $container.find(".itinerary-day").length + 1;
        const index = dayNumber - 1;
        $container.append(dayCardTemplate(index, dayNumber));
    });

    $container.on("click", ".remove-day-btn", function () {
        $(this).closest(".itinerary-day").remove();
        reindexDays();
    });

    $container.closest("form").on("submit", function () {
        reindexDays();
    });
});
