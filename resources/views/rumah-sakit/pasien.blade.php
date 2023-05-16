@extends('layout.app')

@section('navbar')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{url('')}}">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{url('')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('rumah-sakit')}}">Rumah Sakit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('rumah-sakit/pasien')}}">Pasien</a>
                    </li>
                </ul>
                <form class="d-flex">
                    {{--<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>--}}
                </form>
            </div>
        </div>
    </nav>
@endsection

@section('contents')
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header">
                <div class="float-end">
                    <a data-bs-toggle="modal" data-bs-target="#create" href="" class="btn btn-primary">Tambah Data</a>
                </div>
                <h3 class="card-title">Pasien</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <select id="rumkit" onchange="loadRumkit()">
                            <option value="">Semua</option>
                            @forelse($rumkit as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                <table class="table table-hover" id="tableRumkit">
                    <thead>
                    <tr>
                        <th>Nama Pasien</th>
                        <th>Alamat</th>
                        <th>No. Telp.</th>
                        <th>Rumah Sakit</th>
                        <th width="50px">Aksi</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="create" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form class="modal-content" id="form-create">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <select name="nama_rumah_sakit" class="form-select" id="rumah_sakit" aria-label="Floating label select example">
                            @forelse($rumkit as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            @endforelse
                        </select>
                        <label for="rumah_sakit">Rumah Sakit</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="nama_pasien" type="text" class="form-control" id="nama_pasien" placeholder="021 0005555">
                        <label for="nama_pasien">Nama Pasien</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea style="resize: none;height: 100px" name="alamat_pasien" class="form-control" id="alamat_pasien" placeholder="Jalan Jakarta"></textarea>
                        <label for="alamat_pasien">Alamat Pasien</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="nomor_telepon" type="text" class="form-control" id="nomor_telepon" placeholder="021 0005555">
                        <label for="nomor_telepon">Nomor Telepon</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal" id="update" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form class="modal-content" id="form-update">
                @csrf
                <input type="hidden" name="id" id="up_id_pasien">
                <div class="modal-header">
                    <h5 class="modal-title">Create Rumah Sakit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <select name="nama_rumah_sakit" class="form-select" id="up_rumah_sakit" aria-label="Floating label select example">
                            @forelse($rumkit as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            @endforelse
                        </select>
                        <label for="rumah_sakit">Rumah Sakit</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="nama_pasien" type="text" class="form-control" id="up_nama_pasien" placeholder="021 0005555">
                        <label for="up_nama_pasien">Nama Pasien</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea style="resize: none;height: 100px" name="alamat_pasien" class="form-control" id="up_alamat_pasien" placeholder="Jalan Jakarta"></textarea>
                        <label for="up_alamat_pasien">Alamat Pasien</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="nomor_telepon" type="text" class="form-control" id="up_nomor_telepon" placeholder="021 0005555">
                        <label for="up_nomor_telepon">Nomor Telepon</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let dataSets = [];
        var modalCreate = new bootstrap.Modal(document.getElementById('create'), {
            keyboard: false
        });
        var modalUpdate = new bootstrap.Modal(document.getElementById('update'), {
            keyboard: false
        });
        function confirmDelete(nama, id) {
            const conf = confirm(`Delete ${nama} ?`);
            if (conf) {
                $.ajax({
                    url : '{{url('rumah-sakit/pasien/delete')}}', method : 'delete', dataType :'json',
                    data : { '_token' : '{{csrf_token()}}', id : id },
                    error : (e) => { alert(e.responseJSON.message) },
                    success:(e) => {
                        alert(e.message);
                        loadRumkit();
                    }
                })
            }
        }
        function loadRumkit() {
            $.ajax({
                url : '{{url('rumah-sakit/pasien/table')}}', type : 'post', dataType : 'json',
                data : {_token : '{{csrf_token()}}', rumkit : $('#rumkit').val() },
                error : (e) => { alert(e.responseJSON.message)},
                success: (e) => {
                    dataSets = e.data;
                    populateTable(dataSets);
                }
            })
        }
        function populateTable(dataSets = []) {
            const elTable = $('#tableRumkit tbody');
            elTable.html('');
            dataSets.map((item,index)=>{
                const btn =
                    '<button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent"> ' +
                    '<span class="visually-hidden">Toggle Dropdown</span>' +
                    '</button>' +
                    '<ul class="dropdown-menu" aria-labelledby="dropdownMenuReference">' +
                    '<li><a onclick="modalEdit('+index+');return false" class="dropdown-item" href="#">Edit</a></li>' +
                    '<li><a onclick="confirmDelete(\'' + item.name +'\',\''+ item.id + '\');return false" class="dropdown-item" href="#">Delete</a></li>' +
                    '</ul>';
                elTable.append(
                    `<tr><td>${item.name}</td><td>${item.address}</td><td>${item.telp}</td><td>${item.rumah_sakit.name}</td><td>${btn}</td></tr>`
                );
            });
        }
        loadRumkit();
        function modalEdit(index) {
            const data = dataSets[index];
            $('#up_nama_pasien').val(data.name);
            $('#up_id_pasien').val(data.id);
            $('#up_nomor_telepon').val(data.telp);
            $('#up_alamat_pasien').val(data.address);
            $('#up_rumah_sakit').val(data.rumah_sakit.id);
            modalUpdate.show();
        }
        $('#form-create').submit(function (){
            $.ajax({
                url : '{{url('rumah-sakit/pasien/create')}}', method : 'put', data : $('#form-create').serialize(),
                dataType:'json',
                error : (e) => { alert(e.responseJSON.message); },
                success : (e) => {
                    modalCreate.hide();
                    alert(e.message);
                    loadRumkit();
                    $('#nama_pasien,#alamat_pasien,#nomor_telepon').val('');
                }
            });
            return false;
        });
        $("#form-update").submit(function (){
            $.ajax({
                url : '{{url('rumah-sakit/pasien/update')}}', method : 'patch', data : $('#form-update').serialize(),
                dataType:'json',
                error : (e) => { alert(e.responseJSON.message); },
                success : (e) => {
                    modalUpdate.hide();
                    alert(e.message);
                    loadRumkit();
                    $('#up_nama_pasien,#up_alamat_pasien,#up_nomor_telepon').val('');
                }
            });
            return false;
        });
    </script>
@endsection
