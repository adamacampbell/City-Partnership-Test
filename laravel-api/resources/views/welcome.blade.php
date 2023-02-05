<!DOCTYPE html>
<html>

<head>
    <title>FCA Firm Existance Checker</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">

        <!-- FCA API CREDS -->
        <div class="card">
            <div class="card-header text-center font-weight-bold">
                FCA - API Credentials
            </div>
            <div class="card-body">
                <form name="add-fca-creds-form" id="add-fca-creds-form" method="post" action="{{ url('store-form') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">FCA - Email</label>
                        <input type="text" id="email" name="email" class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputKey">FCA - Key</label>
                        <input type="text" id="key" name="key" class="form-control" required="">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <!-- CHECK FIRM EXISTS -->
        <div class="card" style="margin-top: 20px">
            <div class="card-header text-center font-weight-bold">
                FCA - Check Firm Exists
            </div>
            <div class="card-body">
                <form name="fca-check-frn-form" id="fca-check-frn-form" method="post" action="{{ url('store-form') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">FRN</label>
                        <input type="text" id="frn" name="frn" class="form-control" required="">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- STATUS FEEDBACK -->
    @if (session('status'))
        <div class="alert alert-success" style="margin: 40px">
            {{ session('status') }}
        </div>
    @endif
</body>
</html>
