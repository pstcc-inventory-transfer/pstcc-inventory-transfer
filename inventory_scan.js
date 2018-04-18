/* Written by: Ben Millsaps
 * Date last modified: 4/11/18
 */
 
var roomInventoryArray = [];

function generateWorkingList()
{
	var str = $('#roomSelection').val();
	
	$("#roomSelection").hide();
	$("#generateListBtn").hide();
	
	$("#inputBox").show();
	$("#resetBtn").show();
	
	roomInventoryArray = [];
	
	$.ajax(
    {
        method: "POST",
        url: "phpFunctions.php",
        data:
        {
            room: str
        }
    }).done(
	function(results)
	{
		$('.content-area tr').remove();
		
		itemArr = JSON.parse(results);
		itemArr.forEach
		(
			function(element, index)
			{
				var item = 
				{
					itemID: element['TAG'],
					serialNum: element['Serial Number'],
					aquiredDate: element['Aquired Date'],
					custodian: element['Custodian'],
					description: element['Description'],
					roomNum: element['Location'],
					make: element['Make'],
					model: element['Model'],
					price: element['Price'],
					actQuantity: 0
				};
			
				roomInventoryArray.push(item);
			}
		);		
		
		refreshInventoryTable();
	});
}

function updateInventory(str) 
{
	str = cleanId(str);
	var errorFlag = 0;
	
	roomInventoryArray.forEach
	(
		function(element, index)
		{
			if(element.itemID == str)
			{
				if(element.actQuantity > 0)
				{
					var title = "Item Already Scanned";
					var body = "This ID has already been scanned. No changes have been made. Please try again.";
					
					alertModal(title, body);
				}
				
				else
				{
					element.actQuantity = element.actQuantity+1;
					document.getElementById("inputBox").value = "";
				}

				errorFlag = 1;
			}
		}
	);
	
	if((str.length > 5)&&(errorFlag == 0))
	{
		var title = "Inventory Error";
		var body = "The scanned ID is not in the room. No changes have been made. Please try again.";
		
		alertModal(title, body);
	}
	
	refreshInventoryTable();
}

//functionality for manually adjusting quantity. Currently unused but works great.
/*function adjustQty(choice, index) 
{
	if(choice.id == "increment")
		roomInventoryArray[index].actQuantity = roomInventoryArray[index].actQuantity+1;
	
	else if(choice.id == "decrement")
		roomInventoryArray[index].actQuantity = roomInventoryArray[index].actQuantity-1;
	
	else;
	
	refreshInventoryTable();
}*/


function refreshInventoryTable()
{
	$('.content-area tr').remove();
	
	roomInventoryArray.forEach
	(
		function(element, index)
		{
			var body =
			   `<tr id="` + index + `">
				  <td>` + element.itemID + `</td>
				  <td>` + element.serialNum + `</td>
				  <td>` + element.custodian + `</td>
				  <td>` + element.roomNum + `</td>
				  <td>` + element.make + `</td>
				  <td>` + element.model + `</td>
				  <td>` + element.price + `</td>
				  <td>` + element.description + `</td>
				  <td>` + element.aquiredDate + `</td>
			    </tr>`;
				
			var newElement = $.parseHTML(body);

			$('.content-area').append(newElement);
			
			var rowArr = document.getElementById("inventoryScanTable").getElementsByTagName("tr");
			
			if(element.actQuantity == 0)
				rowArr[index+1].style.backgroundColor = "DF534F"; 
			
			else if(element.actQuantity == 1)
				rowArr[index+1].style.backgroundColor = "5CB85C";
			
			else rowArr[index+1].style.backgroundColor = "FCD955"; 
			
			rowArr[index+1].style.color = "white"; 
		}
	);
}

function restartRoomSelection()
{
	$("#roomSelection").show();
	$("#generateListBtn").show();
	
	$("#inputBox").hide();
	$("#resetBtn").hide();
	
	$('.content-area tr').remove();
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

function alertModal(title, body)
{
	$('#alert-modal-title').text(title);
	$('#alert-modal-body').text(body);
	
	$('#alertModal').modal('show');
	
	$('#alertModal').on
	('hide.bs.modal', function (e) 
	{
		document.getElementById("inputBox").value = "";
	});
}