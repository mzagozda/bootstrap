<h2>Loan Calculator</h2>
<p>Use the controls below to calculate your fixed rate loan and press Calculate to see the repayment plan.</p>

<? include DOC_ROOT.'/view/calcparams.php'; ?>
<button class="btn-large" type="button" onclick="calculator.calculateLoan();">Calculate</button>    


<table id="repaymenttable">
  <thead>
    <tr>
      <th>Month</th>
      <th>Balance</th>
      <th>Principle Paid</th>
      <th>Interest Paid</th>
      <th>Payment</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table> 
