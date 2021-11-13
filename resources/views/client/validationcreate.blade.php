{{--

Validuoti viena laukeli

--}}

@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="ajaxForm">
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Client Name</label>
                <input class="form-control col-md-4" type="text" name="name" id="name" value="test" required/>
            </div>
            <div class="form-group row">
                <label for="surname" class="col-md-4 col-form-label text-md-right">Client Surname</label>
                <input class="form-control col-md-4" type="text" name="surname" id="surname" value="test" required/>
            </div>
            <div class="form-group row">
                <button class="btn btn-primary" type="submit" id="validate" >Validate</button>
            </div>
        </div>

        <form>
            <input class="form-control col-md-4" type="email" name="name" id="name" value="test" required/>
            <button type="submit">Submit</button>
        </form>

    </div>
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#validate").click(function() {
            var name = $("#name").val();
            var surname = $("#surname").val();

            $.ajax({
            type: 'POST',
            url: '{{route("client.validationstore")}}',
            data: {name: name, surname: surname},
            success: function(data) {
                console.log(data);
                //data.success
                //data.error
            }
        });
        });

    </script>
@endsection
