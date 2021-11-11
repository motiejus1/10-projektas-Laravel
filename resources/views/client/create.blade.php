@extends('layouts.app')


{{-- Jquery --}}
{{-- galime netureti formos --}}
{{-- ajax siunciama uzklausa turi vykdyti formos paskirti
    tures veiksma - {{route("client.store")}}
    tures metoda - POST
    --}}
@section('content')
{{-- <form action="{{route("client.store")}}" method="POST"> --}}
    {{-- @csrf
    <input type="text" name="clientName" />
    <input type="text" name="clientSurname" />
    <textarea name="clientDescription">
    </textarea>
    <button type="submit">Add </button>
 </form> --}}


    <input type="text" name="clientName" id="clientName"/>
    <input type="text" name="clientSurname" id="clientSurname" />
    <textarea name="clientDescription" id="clientDescription">
    </textarea>
    <button type="submit" id="add" >Add </button>

    <script>


        // console.log($('meta[name="csrf-token"]').attr('content'));

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#add").click(function() {

            var clientName = $("#clientName").val();
            var clientSurname = $("#clientSurname").val();
            var clientDescription = $("#clientDescription").val();

            $.ajax({
                type: 'POST',
                url: '{{route("client.store")}}',
                data: {clientName: clientName, clientSurname: clientSurname, clientDescription: clientDescription  },
                success: function(data) {
                    alert("Client added successfully")
                }
            });
            // console.log(clientName + " " + clientSurname + " " + clientDescription);
        });
        //pasiimti reiksmes is laukeliu
        //ir ivykdyti ajax uzklausa
    </script>

@endsection
