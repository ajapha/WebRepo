<!DOCTYPE html>
<html>
    <head>
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
        </script>
    </body>
</html>
