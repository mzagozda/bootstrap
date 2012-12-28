
$(document).ready(function () {
    calculator.init();
});

var calculator =
    {
        init: function () {
            var initialised = true;
        },

        calculateLoan: function () {
            //event.preventDefault();

            var price = $("#price").val();
            var rate = $("#rate").val();
            var term = $("#term").val();
            var deposit = $("#deposit").val();

            var data =
                {
                    price: price,
                    rate: rate,
                    term: term,
                    deposit: deposit
                };


            $.ajax({
                url: "calculator/calculate",
                type: "POST",
                data: data,
                success: function (data) {
                    //debugger;
                    var tbl_body = "";

                    $.each(data.repayments, function (index, value) {

                        debugger;

                        tbl_body += "<tr>";
                        tbl_body += "<td>" + value.Month + "</td>";
                        tbl_body += "<td>" + value.Balance + "</td>";
                        tbl_body += "<td>" + value.PrincipalPaid + "</td>";
                        tbl_body += "<td>" + value.InterestPaid + "</td>";
                        tbl_body += "<td>" + value.Payment + "</td>";
                        tbl_body += "</tr>";


                    });

                    $("#repaymenttable").show();
                    $("#repaymenttable tbody").html(tbl_body);

                },
                error: function (jqXhr, textStatus, errorThrown) {
                    alert("Invalid parameters have been passed. Check loan parameters and try again. '" + jqXhr.status + "' (textStatus: '" + textStatus + "', errorThrown: '" + errorThrown + "')");
                }
            });


        }
    };
    
