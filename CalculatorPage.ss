<div class="card">
    <div class="card-header">
        <h3 class="text-center">Compound Interest Calculator</h3>
    </div>
    <div class="card-body">
        <div class="row justify-content-md-center">
            <div class="col-md-5">
                <div class="calculator">
                    <form action="home/calculate" method="post" data-persist="garlic">
                        <div class="form-group">
                            <label for="InitialDeposit">Initial Deposit:</label>
                            <div class="input-group flex-nowrap">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="addon-wrapping">GH₵</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter initial deposit" name="InitialDeposit" aria-describedby="addon-wrapping" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Rate">Interest Rate(%):</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Enter rate" name="Rate" required >
                                </div>
                                <div class="col-md-6">
                                    <select name="CompoundRate" class="form-control" required >
                                        <option value="1">annually</option>
                                        <option value="12">monthly</option>
                                        <option value="52">weekly</option>
                                        <option value="365">daily</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Time">Time:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="number" class="form-control" placeholder="Years" name="TimeYear" required >
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" placeholder="Months" name="TimeMonth" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Compounded">Compound Frequency:</label>
                            <select name="CompoundFrequency" class="form-control" required >
                                <option value="1">annually</option>
                                <option value="2">semi-annually</option>
                                <option value="4">quarterly</option>
                                <option value="12">monthly</option>
                                <option value="52">weekly</option>
                                <option value="365">daily</option>
                            </select>
                        </div>
                        <div class="contribution">
                            <p class="text-center">Regular Contributions(Optional)</p>
                            <div class="tab">
                                <button class="tablinks" onclick="contributions(event, 'deposit')" id="defaultOpen">Deposits</button>
                                <button class="tablinks" onclick="contributions(event, 'withdrawal')">Withdrawals</button>
                            </div>
                                
                            <div id="deposit" class="tabcontent">
                                <div class="form-group">
                                    <label for="Rate">Deposit Amount(Optional):</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group flex-nowrap">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="addon-wrapping">GH₵</span>
                                                </div>
                                                <input type="text" class="form-control deposit-amount" name="DepositAmount" aria-describedby="addon-wrapping">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="DepositCompound" class="form-control">
                                                <option value="12">monthly</option>
                                                <option value="52">weekly</option>
                                                <option value="365">daily</option>
                                                <option value="1">annually</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group deposit-made-at">
                                    <label>Deposits made at what point in month?</label>
                                    <select name="DepositMadeAt" class="form-control">
                                        <option value="EndOfMonth">End</option>
                                        <option value="BeginningOfMonth">Beginning</option>
                                    </select>
                                </div>
                                <div class="custom-control custom-switch" style="margin-top: 20px; margin-bottom: 20px;">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1">Increase deposits yearly with inflation?</label>
                                </div>
                                <div class="form-group increase-deposits">
                                    <label>Annual inflation rate(%)?(Optional):</label>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" placeholder="Enter rate" name="DepositAnnualInflationRate" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="withdrawal" class="tabcontent">
                                <div class="form-group">
                                    <label for="Rate">Withdrawal Amount(Optional):</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group flex-nowrap">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="addon-wrapping">GH₵</span>
                                                </div>
                                                <input type="text" class="form-control withdrawal-amount" name="WithdrawalAmount" aria-describedby="addon-wrapping">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="WithdrawalCompound" class="form-control">
                                                <option value="12">monthly</option>
                                                <option value="52">weekly</option>
                                                <option value="365">daily</option>
                                                <option value="1">annually</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group withdrawal-made-at">
                                    <label>Withdrawals made at what point in month?</label>
                                    <select name="WithdrawalMadeAt" class="form-control">
                                        <option value="EndOfMonth">End</option>
                                        <option value="BeginningOfMonth">Beginning</option>
                                    </select>
                                </div>
                                <div class="custom-control custom-switch" style="margin-top: 20px; margin-bottom: 20px;">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                    <label class="custom-control-label" for="customSwitch2">Increase withdrawals yearly with inflation?</label>
                                </div>
                                <div class="form-group increase-withdrawals">
                                    <label for="Compounded">Annual inflation rate(%)?(Optional):</label>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" placeholder="Enter rate" name="WithdrawalAnnualInflationRate" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg btn-block fa fa-calculator"> Calculate</button>
                            </div>
                            <div class="col-md-6">
                                <a href="/home" class="btn btn-danger btn-lg btn-block fa fa-sync-alt"> Refresh</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <% if $CompoundInterest %>
            <br><br>
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <div class="output badge badge-light">
                        <span>$Title</span><hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Future Investment Value</p>
                                <span>GH₵ $CompoundInterest</span>
                                <br><br><br><br>
                                <p>Total Interest Earned</p>
                                <span>GH₵ $TotalInterestEarned</span>
                            </div>
                            <div class="col-md-6">
                                <p>Initial Balance</p>
                                <span>GH₵ $InitialBalance</span>
                                <% if $TotalDeposit > 0 %>
                                    <br><br><br><br>
                                    <p>Total Deposit</p>
                                    <span>GH₵ $TotalDeposit</span>
                                <% end_if %>
                                <br><br><br><br>
                                <p>Effective Annual Rate (APY)</p>
                                <span>$EffectiveAnnualRate %</span>
                            </div>
                        </div>
                        <hr>
                        <span>Projection Breakdown</span><br><br>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <%-- <th>Starting Balance(GH₵)</th> --%>
                                    <% if $Deposit %>
                                        <th>Deposit(GH₵)</th>
                                        <th>Total Deposit(GH₵)</th>
                                    <% end_if %>
                                    <th>Interest(GH₵)</th>
                                    <th>Total Interest(GH₵)</th>
                                    <th>Balance(GH₵)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <% loop $TableProject %>
                                    <tr>
                                        <th>$Year</th>
                                        <%-- <td>$Principal</td> --%>
                                        <% if $Deposit %>
                                            <td>$Deposit</td>
                                            <td>$TotalDeposit</td>
                                        <% end_if %>
                                        <td>$Interest</td>
                                        <td>$TotalInterest</td>
                                        <td>$Balance</td>
                                    </tr>
                                <% end_loop %>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <% end_if %>
    </div>
    <br><br><br>
    <div class="card-footer text-muted text-center">
        Copyright @$Now.Year Coldsis Ghana Limited. All Rights Reserved
    </div>
</div>