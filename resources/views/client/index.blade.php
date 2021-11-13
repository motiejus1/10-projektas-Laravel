@extends('layouts.app')

@section('content')
<div class="container">

    <div class="ajaxForm">
        <div class="form-group row">
            <label for="clientName" class="col-md-4 col-form-label text-md-right">Client Name</label>
            <input class="form-control col-md-4" type="text" name="clientName" id="clientName"/>
            <span class="invalid-feedback clientName" role="alert">
            </span>
        </div>
        <div class="form-group row">
            <label for="clientSurname" class="col-md-4 col-form-label text-md-right">Client Surname</label>
            <input class="form-control col-md-4" type="text" name="clientSurname" id="clientSurname" />
            <span class="invalid-feedback clientSurname" role="alert">
            </span>
        </div>
        <div class="form-group row">
            <label for="clientDescription" class="col-md-4 col-form-label text-md-right">Client Description</label>
            <textarea class="form-control col-md-4" name="clientDescription" id="clientDescription">
            </textarea>
            <span class="invalid-feedback clientDescription" role="alert">
            </span>
        </div>
        <div class="form-group row">
            <button class="btn btn-primary" type="submit" id="add" >Add </button>
            <button class="btn btn-danger" id="dummyAdd">Dummy Add</button>
        </div>
    </div>

    <table id="clients" class="table table-striped">
        <tr>
            <th> ID </th>
            <th> Name </th>
            <th> Surname </th>
            <th> Description </th>
            <th> Action </th>
        </tr>
        @foreach ($clients as $client)
            <tr class="client">
                <td>{{$client->id}}</td>
                <td> {{$client->name}} </td>
                <td> {{$client->surname}} </td>
                <td> {!! $client->description !!} </td>
                <td>
                    <form method="POST" action={{route("client.destroy", [$client])}}>
                        @csrf
                        <button class="btn btn-danger">DELETE </button>
                    </form>

                    <button class="btn btn-success delete" data-clientid="{{$client->id}}" >DELETE AJAX </button>
                </td>
            </tr>
        @endforeach
    </table>
</div>

<script>


    // console.log($('meta[name="csrf-token"]').attr('content'));

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".delete").click(function() {

        $(this).parents('.client').remove();

        console.log($(this).attr("data-clientid"));

        $.ajax({
            type: 'POST',
            url: '/clients/destroy/' + $(this).attr("data-clientid"),
            success: function(data) {
                alert("Deleted");
            }
        });
    })

    $("#add").click(function() {

        var clientName = $("#clientName").val();
        var clientSurname = $("#clientSurname").val();
        var clientDescription = $("#clientDescription").val();

        //javascript masyvas - json
        //jisai suprasti tik json formata

        $.ajax({
            type: 'POST',
            url: '{{route("client.store")}}',
            data: {clientName: clientName, clientSurname: clientSurname, clientDescription: clientDescription  },
            success: function(data) {

                // console.log(data);
                if($.isEmptyObject(data.error)) {

                    $(".invalid-feedback").css('display','none');
                    $("#clients").append("<tr><td>"+data.clientID+"</td><td>"+data.clientName+"</td><td>"+data.clientSurname+"</td><td>"+data.clientDescription+"</td><td>Actions</td></tr>")
                    // alert(data.message);
                } else {
                    $(".invalid-feedback").css('display','none');
                    $.each(data.error, function(key, error){
                        var errorSpan= "." + key;
                        $(errorSpan).css('display', 'block');
                        $(errorSpan).html('');
                        $(errorSpan).append("<strong>"+error+"</strong>");
                    });
                }
                // $("#clients").append("<tr><td>"+data.clientID+"</td><td>"+data.clientName+"</td><td>"+data.clientSurname+"</td><td>"+data.clientDescription+"</td><td>Actions</td></tr>")
                // alert(data.message);

            }
        });
        // console.log(clientName + " " + clientSurname + " " + clientDescription);
    });
    //pasiimti reiksmes is laukeliu
    //ir ivykdyti ajax uzklausa
</script>

@endsection
