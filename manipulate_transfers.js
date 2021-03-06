/* Written by: Jon Knight, Mathew Ratliff
 * Date last modified: 4/01/18
 * Dependencies: desktop.html
 */

var transfersArray = [];
var selectedTransferID;
var filename = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1);

// Stored conditional functions
var isIdValid = function()
{
    return $('#model').val() !== '' && $('#pre_room').val() !== '' && $('#pre_owner').val() !== '' && $('#pre_dept').val() !== '';
};
var isOptionSelected = function()
{
    return $('#newRoom').val() != null && $('#newOwner').val() != null && $('#newDept').val() != null;
};
var isDuplicate = function()
{
    var status = false;
    transfersArray.forEach(function(element, index)
    {
        if ($('#IDAdd').val().toUpperCase() === element.itemID.toUpperCase() && index != selectedTransferID)
        {
            status = true;
        }
    });
    return status;
};

window.onbeforeunload = function(e)
{
    return 'Are you sure?';
};

function refreshListDesktop()
{
    $('.content-area tr').remove();

    transfersArray.forEach(function(element, index)
    {
        var itemID = element.itemID;
        var newRoom = element.newRoom;
        var newOwner = element.newOwner;
        var newDept = element.newDept;
        var notes = element.notes;
        var model = element.model;
        var preRoom = element.preRoom;
        var preOwner = element.preOwner;
        var preDept = element.preDept;

        var html =
        `<tr id="` + index + `">
        <td>` + itemID + `</td>
        <td>` + model + `</td>
        <td>` + preRoom + `</td>
        <td>` + preOwner + `</td>
        <td>` + preDept + `</td>
        <td>` + newRoom + `</td>
        <td>` + newOwner + `</td>
        <td>` + newDept + `</td>
        <td>` + notes.substr(0, 25) + `</td>
        <td>
            <button data-toggle="modal" data-target="#Add_Modal" class="btn btn-primary btn-sm" onclick="setSelectedID(this)">Edit</button>
        </td>
        <td>
            <button class="btn btn-danger btn-md" onclick="deleteTransfer(this)"><span class="glyphicon glyphicon-trash"></span></button>
        </td>
    </tr>`;
        var newElement = $.parseHTML(html);

        $('.content-area').append(newElement);
    });
}

function refreshListMobile()
{
    $('.mobile .panel').remove();

    transfersArray.forEach(function(element, index)
    {
        var itemID = element.itemID;
        var newRoom = element.newRoom;
        var newOwner = element.newOwner;
        var newDept = element.newDept;
        var notes = element.notes;
        var model = element.model;
        var preRoom = element.preRoom;
        var preOwner = element.preOwner;
        var preDept = element.preDept;

        var html =
            `<div class="panel panel-primary" data-toggle="collapse" href="#` + index + `">
                   <div class="panel-heading">
                      <h4 class="panel-title">
                         <a><b>ID#</b> ` + itemID + ` | ` + model + `</a>
                         <span class="glyphicon glyphicon-chevron-down pull-right"></span>
                       </h4>
                   </div>
                   <div id="` + index + `" class="panel-collapse collapse">
                       <div class="panel-body">
                           <table class="table table-condensed">
                               <tr><td><b>Model </b></td><td>` + model + `</td></tr>
                               <tr><td><b>Previous Room </b></td><td>` + preRoom + `</td></tr>
                               <tr><td><b>Previous Owner </b></td><td>` + preOwner + `</td></tr>
                               <tr><td><b>Previous Dept. </b></td><td>` + preDept + `</td></tr>
                               <tr><td><b>New Room </b></td><td>` + newRoom + `</td></tr>
                              <tr><td><b>New Owner </b></td><td>` + newOwner + `</td></tr>
                               <tr><td><b>Dept. To </b></td><td>` + newDept + `</td></tr>
                           </table>

                           <p><b>Notes: </b>` + notes + `</p>
                           <button class="btn btn-danger delete-btn" onclick="deleteTransfer(this)">Remove</button>
                           <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#Add_Modal" onclick="setSelectedID(this)">Edit</button>
                       </div>
                   </div>
                   </div>`;

        var newElement = $.parseHTML(html);

        $('.mobile').append(newElement);
    });
}


// * Called when the delete button is clicked.
//
// * Removes selected object from the array, and refreshes the list.

function deleteTransfer(button)
{
    if (confirm('Permanently delete this transfer?'))
    {
        if (filename === "inventory-transfer.php")
        {
            var index = $(button).closest('tr').attr('id');
            transfersArray.splice(index, 1);
            $(button).closest('tr').remove();
        }
        else
        {
            var index = $(button).closest('.panel-collapse').attr('id');
            transfersArray.splice(index, 1);
            $(button).closest('.panel').remove();
        }
    }
}

// * Called when user presses the edit button.
//
// * Stores the index of the object in a global variable.
function setSelectedID(button)
{
    if (filename === "inventory-transfer.php")
    {
        selectedTransferID = parseInt($(button).closest('tr').attr('id'));
    }
    else
    {
        selectedTransferID = parseInt($(button).closest('.panel-collapse').attr('id'));
    }


    $('#IDAdd').val(transfersArray[selectedTransferID].itemID);
    $('#newRoom').selectpicker('val', transfersArray[selectedTransferID].newRoom);
    $('#newOwner').selectpicker('val', transfersArray[selectedTransferID].newOwner);
    $('#newDept').selectpicker('val', transfersArray[selectedTransferID].newDept);
    $('#notes').val(transfersArray[selectedTransferID].notes);
    $('#model').val(transfersArray[selectedTransferID].model);
    $('#pre_room').val(transfersArray[selectedTransferID].preRoom);
    $('#pre_owner').val(transfersArray[selectedTransferID].preOwner);
    $('#pre_dept').val(transfersArray[selectedTransferID].preDept);
}

// * Stringifies the object array in JSON format.
//
function submitFinal()
{
    if (transfersArray.length != 0)
    {
        var jsonString = JSON.stringify(transfersArray);

        $.ajax(
        {
            method: "POST",
            url: "addTransfers.php",
            data:
            {
                json: jsonString
            },
            error: function ()
            {
                if (filename === "inventory-transfer.php")
                {
                    transfersArray = [];
                    refreshListDesktop();
                }
                else
                {
                    transfersArray = [];
                    refreshListMobile();
                }

                alertModal("alert", "Success", "Transfers were successfully submitted.");
            },
            success: function ()
            {
                alertModal("alert", "Success", "Transfers were successfully submitted.");
            },
            timeout: 5000
        }).done(function(results)
        {
            console.log(results);

            if(results == "true")
            {
                if (filename === "inventory-transfer.php")
                {
                    transfersArray = [];
                    refreshListDesktop();
                }
                else
                {
                    transfersArray = [];
                    refreshListMobile();
                }

                alertModal("alert", "Success", "Transfers were successfully submitted.");
            }
            else
            {
                alertModal("error", "Error", "There was an error submitting these transfers. " + results);
            }
        });
    }
    else
    {
        alertModal('error', 'Error', "Please add transfers before submitting.");
    }
}
// * Determines if the user is trying to edit a transfer, or create a new one.
function submit()
{
    if (isIdValid())
    {
        if (isOptionSelected())
        {
            if (!isDuplicate())
            {
                if (selectedTransferID === undefined)
                {
                    submitNew();
                }
                else
                {
                    submitEdit();
                }
            }
            else alertModal('error', 'Error', "It appears this item is already being transfered");
        }
        else alertModal('error', 'Error', "Please ensure you've completed all required fields.");
    }
    else alertModal('error', 'Error', "Please enter a valid ID");
}

function cleanId(str)
{
    if(str.length > 7)
    {
         str = str.split(' ');
         return str[0];
    }
	else return str;
}

// * Called when a transfer is to be edited.
//
// * Doesn't alter object unless there are no errors in the modal.
//
// * Refreshes the list when the object's fields have been altered in the array.
function submitEdit()
{
    transfersArray[selectedTransferID].itemID = $('#IDAdd').val().toUpperCase();
    transfersArray[selectedTransferID].newRoom = $('#newRoom').val();
    transfersArray[selectedTransferID].newOwner = $('#newOwner').val();
    transfersArray[selectedTransferID].newDept = $('#newDept').val();
    transfersArray[selectedTransferID].notes = $('#notes').val();
    transfersArray[selectedTransferID].model = $('#model').val();
    transfersArray[selectedTransferID].preRoom = $('#pre_room').val();
    transfersArray[selectedTransferID].preOwner = $('#pre_owner').val();
    transfersArray[selectedTransferID].preDept = $('#pre_dept').val();
    if (filename === "inventory-transfer.php")
        refreshListDesktop();
    else
        refreshListMobile();

    $('#Add_Modal').modal('hide');
    selectedTransferID = undefined;
}



// * Called when a new transfer is added to the object array.
//
// * Doesn't create object unless there are no errors in the modal.
//
// * Refreshes the list when the new object is added to the array.
function submitNew()
{
    var transfer = {
		technician: $('#technician').val(),
        itemID: $('#IDAdd').val().toUpperCase(),
        newRoom: $('#newRoom').val(),
        newOwner: $('#newOwner').val(),
        newDept: $('#newDept').val(),
        notes: $('#notes').val(),
        model: $('#model').val(),
        preRoom: $('#pre_room').val(),
        preOwner: $('#pre_owner').val(),
        preDept: $('#pre_dept').val(),
    };

    transfersArray.push(transfer);

    if (filename === "inventory-transfer.php")
        refreshListDesktop();

    else refreshListMobile();

    $('#Add_Modal').modal('hide');
}

// * Registers a handler for the modal close event.
//
// * Clears all fields on modal close.
$('#Add_Modal').on('hidden.bs.modal', function()
{
    $('#IDAdd').removeClass('error');
    $('#IDAdd').removeClass('success');

    $('#IDAdd').val('');
    $('#newRoom').selectpicker('val', 'none');
    $('#newOwner').selectpicker('val', 'none');
    $('#newDept').selectpicker('val', 'none');
    $('#notes').val('');
    $('#model').val('');
    $('#pre_room').val('');
    $('#pre_owner').val('');
    $('#pre_dept').val('');
});

function alertModal(style, title, body)
{
    $('#alert-modal-title').text(title);
    $('#alert-modal-body').text(body);

    if(style == "error")
    {
        $('.alert-header').css('background-color', '#ff4444');
    }
    else if (style == "alert")
    {
        $('.alert-header').css('background-color', '#33b5e5');
    }

    $('#alertModal').modal('show');
}

// * Takes the value in the ID field, searches the database for the associated info via Ajax,
//   and returns the results to the appropriate fields.
//
// * Changes the color of the text field upon either success or error.
function getInfoFromTag(str)
{
    $.ajax(
    {
        method: "POST",
        url: "phpFunctions.php",
        data:
        {
            idNum: str
        }
    }).done(function(results)
    {
        console.log(results);
        $('#IDAdd').val(cleanId($('#IDAdd').val()));

        if (results.trim() != 'error' && results.trim() != '')
        {
            var resultsArr = results.split(",");

            if ($('#IDAdd').hasClass('has-error'))
            {
                $('#IDAdd').removeClass('error');
                $('#IDAdd').addClass('success');
            }
            else
            {
                $('#IDAdd').addClass('success');
            }

            $("#model").val(resultsArr[0]);
            $("#pre_room").val(resultsArr[1]);
            $("#pre_owner").val(resultsArr[2]);
            $("#pre_dept").val("Not available");
        }
        else
        {
            if ($('#IDAdd').hasClass('success'))
            {
                $('#IDAdd').removeClass('success');
                $('#IDAdd').addClass('error');
            }
            else
            {
                $('#IDAdd').addClass('error');
            }

            $("#model").val("");
            $("#pre_room").val("");
            $("#pre_owner").val("");
            $("#pre_dept").val("");
        }
    });
}
