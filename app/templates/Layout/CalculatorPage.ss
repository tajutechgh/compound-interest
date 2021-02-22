<div class="card">
    <div class="card-header">
        <h3 class="text-center">Compound Interest Calculator</h3>
    </div>
    <div class="card-body">
        <div class="row justify-content-md-center">
            <div class="col-md-4">
                <div class="calculator">
                    <form action="home/calculate" method="post">
                        <div class="form-group">
                            <label for="InitialDeposit">Initial Deposit:</label>
                            <input type="text" class="form-control" placeholder="Enter initial deposit" name="InitialDeposit" required >
                        </div>
                        <div class="form-group">
                            <label for="Rate">Rate(%):</label>
                            <input type="number" class="form-control" placeholder="Enter rate" name="Rate" required >
                        </div>
                        <div class="form-group">
                            <label for="Compounded">Compound Frequency:</label>
                            <select name="CompoundFrequency" class="form-control" required >
                                <option value="1">annually</option>
                                <option value="12">monthly</option>
                                <option value="52.14">weekly</option>
                                <option value="365">daily</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Time">Time:</label>
                            <input type="number" class="form-control" placeholder="Enter number of years" name="Time" required >
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Calculate</button>
                            </div>
                            <div class="col-md-6">
                                <a href="/home" class="btn btn-danger btn-lg btn-block">Refresh</a>
                            </div>
                        </div>
                    </form>
                </div>
                <% if $CompoundInterest %>
                    <br><br>
                    <div class="output badge badge-info">
                        <span>$Title</span><br><br>
                        <span>GH₵ $CompoundInterest</span>
                    </div>
                <% end_if %>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted text-center">
        Copyright @$Now.Year Coldsis Ghana Limited. All Rights Reserved
    </div>
</div>