<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>JavaScript Electronics Store</title>
        <style>
            button {
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
        </script>
    </body>
</html>
