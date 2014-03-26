<!DOCTYPE html>
<html>
    <head>
<<<<<<< HEAD
        <meta charset="UTF-8">
        <title>JavaScript Electronics Store</title>
        <style>
            button {
                text-align: match-parent;
                display: inline-block;
                height: 100px;
                width: 100px;
                margin: 10px;
            }
            table, td {
                border: 1px solid black;
                padding: 4px;
            }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    </head>
    <body>
        <h1>JS Electronics</h1>
        Please choose from the following categories:<br><br>
        <button id="comp"><br>Computers and Laptops<br><br></button>
        <button id="tablets"><br><br>Tablets<br><br></button>
        <button id="print">Printers, Scanners and All-In-One Machines</button>
        <table id="table"> 
            <thead>
                <tr>
                    <td>Product Number</td>
                    <td>Model</td>
                    <td>Description</td>
                    <td>Price</td>
                    <td>Image</td>
                </tr>
            </thead>
            <tbody id="tableBody">
                
            </tbody>
        </table>
        <script>
=======
        <title>Ajax Test</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
         <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
         <style>
             thead {
                 font-weight: bold;
             }
            td {
                border: 1px solid black;
                margin: 0;
                border-collapse: collapse;
                border-spacing: 0;
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <h1> Welcome to our searchable employee database.</h1>
        <div>
            Type the first few letters of the last name of the person you want to find.<br>
            <input id="selection" type="text">
            <button id="submit">Submit</button><br><br> 
        </div>
        <div>
            <table>
                <thead id="header">
                    <tr>
                        <td>Employee Number</td>
                        <td>Birth Date</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Gender</td>
                        <td>Hire Date</td>
                    </tr>
                </thead>
                <tbody id="theTable">
                    
                </tbody>
            </table>
        </div>
        <script>
            $("#header").hide();
>>>>>>> d3276ff83e9c21cdf9925830d0f9c3123d05c56d
            function tableWrap (tableID) {
                var table = document.getElementById(tableID);
                return {
                    addRow: function(columnInfo) { //columnInfo should be array of info to fill the columns of the row.
                        if (!Array.isArray(columnInfo)) {
                            columnInfo = [columnInfo];
                        }
                        row = table.insertRow(-1);
                        columns = columnInfo.length;
                        for (i = 0; i < columns; i++) {
                            row.insertCell(i).innerHTML = columnInfo[i];
                        }
                   }
               };
<<<<<<< HEAD
            }
            var wrappedTable = tableWrap("tableBody");
            $("#table").hide();
            function addButtonClick(buttonID, keyWord) {
                $("#"+buttonID).click(function() {
                       $("#table").show();
                       $("#tableBody").children().remove();
                       url = "storeDB.php?key=" + keyWord;
                       $.getJSON(url, function(dbData) {
                           $.each(dbData, function(i, dataLine) {
                               rowEntry = [dataLine["productNum"], dataLine["model"], dataLine["description"], dataLine["price"], "<img src=" + dataLine["image"]+ ">"];
                               console.dir(rowEntry);
                               wrappedTable.addRow(rowEntry);
                           });
                   }); 
                });
            }
            addButtonClick("comp", "computer");
            addButtonClick("tablets", "tablet");
            addButtonClick("print", "printer");
            
=======
            }     
            var table = tableWrap("theTable");
            var t = document.getElementById("theTable");
            var textBox = document.getElementById("selection");
            var button = document.getElementById("submit");
            button.addEventListener("click", function() {
                $("#theTable").children().remove();
                selection = textBox.value;
                url = "get.php?info=" + selection;
                $.getJSON(url, function(info) {
                    if (info.length !== 0) {
                        $("#header").show();
                        $.each(info, function(i, item) {
                            rowInfo = [item["emp_no"], item["birth_date"], item["first_name"], item["last_name"], item["gender"], item["hire_date"]];  
                            table.addRow(rowInfo);
                        });
                    }
                    else {
                        $("#header").hide();            
                        table.addRow("There are no employees with that last name.");    
                    }
                    
                });
                textBox.value = " ";
            });    
>>>>>>> d3276ff83e9c21cdf9925830d0f9c3123d05c56d
        </script>
    </body>
</html>
