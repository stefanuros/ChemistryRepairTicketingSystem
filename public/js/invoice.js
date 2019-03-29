// Invoice page
// Made by stefan urosevic

$(document).ready(function() {
	$("#add-item").click(function(){

		$.post("./includes/DBinteractivity/invoiceFunctionality.php",
		{
			func: "ADD",
			ticket_id: ticket_id
		}, function(data)
		{
			$("#row-marker").before(`
			<div class="row p-1" id="row-`+ data +`">
				<div class="col-xl-6 col-sm-4 pr-1">
					<input type="text" class="form-control item-general" id="name-`+ data +`" placeholder="Enter item name or description" value="">
				</div>
				<div class="col-xl-2 col-sm-1 px-1">
					<input type="number" class="form-control quantity-general" oninput="calcTotal()" id="quantity-`+ data +`" value="0">
				</div>
				<div class="col-xl-2 col-sm-3 px-1 input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">$</span>
					</div>
					<input type="number" class="form-control price-general" oninput="calcTotal()" id="price-`+ data +`" step="0.01" value="0.00">
				</div>
				<div class="col-xl-1 col-sm-2 px-1">
						<button type="button" class="price-update btn btn-outline-success btn-block px-1" onclick="saveRow('`+ data +`')">Save</button>
				</div>
				<div class="col-xl-1 col-sm-2 pl-1">
						<button type="button" class="price-update btn btn-outline-danger btn-block px-1" onclick="deleteRow('`+ data +`', true)">Delete</button>
				</div>
			</div>
			`);
		});
	});

	calcTotal();

});

var latestID = "";

function deleteRow(id, firstClick)
{
	// If if it first click on delete and there is no id, something went wrong
	if(id == "" && firstClick)
	{
		setAlert("Error with deleting", "danger");
		return;
	}

	// If it is the first click on delete, start the confirmation modal
	if(firstClick)
	{
		latestID = id;
		// Create modal
		$('#del-confirmation').modal('show');

		// Show the info being deleted in the modal
		$("#modal-name")[0].value = $("#name-" + id)[0].value;
		$("#modal-quantity")[0].value = $("#quantity-" + id)[0].value;
		$("#modal-price")[0].value = $("#price-" + id)[0].value;

		return;
	}	

	// latestID stores the id to be deleted after confirmation
	id = latestID;
	latestID = "";
	// Close the modal
	$("#del-confirmation").modal("hide");

	$.post("./includes/DBinteractivity/invoiceFunctionality.php",
	{
		func: "DELETE",
		ticket_id: ticket_id,
		part_id: id,
	}, function(data)
	{
		setAlert("Row deleted", "success");
		$("#row-" + id).remove();
	});

}

function saveRow(id)
{
	var name = $("#name-" + id)[0].value;
	var quantity = $("#quantity-" + id)[0].value;
	var price = parseFloat($("#price-" + id)[0].value).toFixed(2);

	$("#price-" + id)[0].value = price;

	$.post("./includes/DBinteractivity/invoiceFunctionality.php",
	{
		func: "UPDATE",
		ticket_id: ticket_id,
		part_id: id,
		name: name,
		quantity: quantity,
		price: price
	}, function(data)
	{
		setAlert("Item saved", "success");
	});
	//ajax post to update a part
}

function calcTotal()
{
	//Get the prices and quanities
	var p = document.getElementsByClassName("price-general");
	var q = document.getElementsByClassName("quantity-general");
	
	var tot = 0;
	
	//Add them all up
	for(var i = 0; i < p.length; i++)
	{
		var tempSum = parseFloat(p[i].value) * parseFloat(q[i].value);

		tempSum = (isNaN(tempSum) ? 0 : tempSum);

		tot += tempSum;
	}

	if(isNaN(tot))
	{
		tot = 0.00;
	}

	$("#total-price")[0].value = tot.toFixed(2);
}

function setAlert(msg, type)
{
	var a = `
	<div class="alert alert-` + type + ` alert-dismissible fade show" role="alert">
		` + msg + `
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	`;

	$("#alertMarker")[0].innerHTML = a;

	$(".alert").delay(5000).slideUp(200, function() {
		$(this).alert('close');
	});
}

function generatePDF()
{
	setAlert("Printing. Please wait", "warning");
	var rows = [];

	// Gather the invoice items
	var items = $(".item-general");
	var quanities = $(".quantity-general");
	var prices = $(".price-general");

	// console.log(items);

	// Get the values of them and make the list
	for (var i = 0; i < items.length; i++)
	{
		rows.push({
			name: items[i].value,
			quantity: quanities[i].value,
			unit_cost: prices[i].value
		})
	}

	// Create the rest of the pdf data
	var pdfData = {
		from: "Queen's Chemistry Repair Dept",
		to: "Queen's Chemistry Finance Dept\n" + superName + "\n" + superCode,
		logo: "https://www.chem.queensu.ca/sites/webpublish.queensu.ca.chemwww/files/images/chemlogocolour%20JPEG.jpg",
		number: ticket_id,
		items: rows
	};

	// Create the url
	var pdfurl = './includes/DBinteractivity/generatePDF.php?data=' + JSON.stringify(pdfData) + "&t=" + ticket_id; 

	// Open it in a new window
	window.open(pdfurl, '_blank');

	// $.post("./includes/DBinteractivity/generatePDF.php",
	// {
	// 	data: JSON.stringify(pdfData)
	// }, function(data)
	// {
	// 	setAlert("PDF Created", "success");
	// 	console.log(data);
	// });


}
