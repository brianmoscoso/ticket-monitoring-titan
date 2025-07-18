$(document).ready(function () {
    console.log("JavaScript Loaded!");

    // Initialize Bootstrap Multiselect
    $('#work_type').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '100%',
        nonSelectedText: 'Select Activity',
        allSelectedText: 'All Selected',
        selectAllText: 'Select All'
    });

    // Toggle dropdown on button click
    $('.multiselect').on('click', function (event) {
        event.stopPropagation();
        var dropdown = $(this).closest('.btn-group').find('.multiselect-container');
        if (dropdown.is(':visible')) {
            dropdown.hide();
        } else {
            $('.multiselect-container').hide();
            dropdown.show();
        }
    });

    // Hide dropdown when clicking outside
    $(document).on('click', function () {
        $('.multiselect-container').hide();
    });

    // Ensure dropdown remains visible when interacting inside it
    $(document).on('click', '.multiselect-container', function (event) {
        event.stopPropagation();
    });

    // Handle Edit Worknote
    $(document).on('click', '.edit-worknote', function () {
        var worknoteId = $(this).data('id');
        console.log("Edit clicked - ID:", worknoteId);

        var worknoteText = $("#worknote-" + worknoteId + " .worknote-text").text();

        $("#worknote-" + worknoteId + " .worknote-text").html(`
            <input type="text" class="form-control edit-input" value="${worknoteText}">
            <button class="btn btn-success btn-sm save-worknote" data-id="${worknoteId}">Save</button>
            <button class="btn btn-secondary btn-sm cancel-edit" data-id="${worknoteId}">Cancel</button>
        `);
    });

    // Cancel Editing
    $(document).on('click', '.cancel-edit', function () {
        console.log("Cancel clicked");
        location.reload();
    });

    // Save Edited Worknote
    $(document).on('click', '.save-worknote', function () {
        var worknoteId = $(this).data('id');
        var newText = $("#worknote-" + worknoteId + " .edit-input").val();
        console.log("Save clicked - ID:", worknoteId, "New text:", newText);

        $.post('update_worknote.php', { id: worknoteId, body: newText }, function (response) {
            console.log("Response from server:", response);

            if (response.success) {
                $("#worknote-" + worknoteId + " .worknote-text").text(newText);
                alert('Worknote updated successfully!');
            } else {
                alert('Error: ' + response.error);
            }
        }, 'json').fail(function (xhr, status, error) {
            console.error("AJAX Error:", error, xhr.responseText);
            alert("Failed to update worknote. Check console for details.");
        });
    });

    // Delete Worknote
    $(document).on('click', '.delete-worknote', function () {
        var worknoteId = $(this).data('id');
        console.log("Delete clicked - ID:", worknoteId);

        if (confirm('Are you sure you want to delete this worknote?')) {
            $.post('delete_worknote.php', { id: worknoteId }, function (response) {
                console.log("Server Response:", response);
                if (response.success) {
                    $("#worknote-" + worknoteId).fadeOut();
                } else {
                    alert('Failed to delete worknote');
                }
            }, 'json').fail(function (xhr) {
                console.log("Error:", xhr.responseText);
            });
        }
    });

    // Add Worknote
    $('#add-worknote').on('click', function () {
        var ticketId = $('#ticket-id').val();
        var remark = $('#new-remark').val().trim();
        var formData = new FormData();
        var fileInput = $('#screenshot')[0].files[0];

        if (remark === "" && !fileInput) {
            alert('Please add a remark or upload a screenshot.');
            return;
        }

        formData.append("ticket_id", ticketId);
        formData.append("remark", remark);
        if (fileInput) {
            formData.append("screenshot", fileInput);
        }

        $.ajax({
            url: './src/add-worknotes.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                if (response.status === 200) {
                    var author = response.author || "Unknown";
                    var newNote = `<li><strong>${author}</strong> (Just Now): ${remark}`;

                    if (response.screenshot_path) {
                        var imagePath = response.screenshot_path;
                        newNote += `<br>
                        <a href="${imagePath}" target="_blank">
                        <img src="${imagePath}" class="worknote-img" alt="Screenshot">
                        </a>`;
                    }

                    newNote += `</li>`;

                    $('#worknotes-list').prepend(newNote);
                    $('#new-remark').val('');
                    $('#screenshot').val('');
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", xhr.responseText);
                alert('Error processing request: ' + error);
            }
        });
    });

    // Worknote Search
    const searchInput = document.getElementById("search-worknotes");
    const worknotesList = document.getElementById("worknotes-list");

    if (searchInput && worknotesList) {
        searchInput.addEventListener("keyup", function () {
            let query = this.value.trim();
            let ticketId = $('#ticket-id').val();

            if (query === "") {
                fetchWorknotes(ticketId, "");
            } else {
                fetchWorknotes(ticketId, query);
            }
        });

        function fetchWorknotes(ticketId, query) {
            fetch("search_worknotes.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `ticket_id=${ticketId}&query=${encodeURIComponent(query)}`
            })
            .then(response => response.json())
            .then(data => {
                worknotesList.innerHTML = "";
                if (data.success) {
                    data.worknotes.reverse().forEach(note => {
                        let listItem = document.createElement("li");
                        listItem.id = `worknote-${note.id}`;
                        listItem.innerHTML = `
                            <strong>${note.author}</strong> (${note.created_at}): 
                            <span class='worknote-text'>${note.body}</span>
                            <div class='mt-2'>
                                <button class='btn btn-sm btn-primary edit-worknote' data-id='${note.id}'>Edit</button>
                                <button class='btn btn-sm btn-danger delete-worknote' data-id='${note.id}'>Delete</button>
                            </div>
                        `;
                        worknotesList.appendChild(listItem);
                    });
                }
            })
            .catch(error => console.error("❌ Fetch error:", error));
        }
    }
});
