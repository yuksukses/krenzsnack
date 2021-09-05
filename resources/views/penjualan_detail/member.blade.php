<div class="modal inmodal" id="modal-member" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <i class="fa fa-vcard modal-icon"></i>
                <h4 class="modal-title">Pilih Member</h4>
            </div>
            <div class="modal-body">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-member">
                            <thead>
                                <th width="2%">No</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th width="5%"><i class="fa fa-cog"></i></th>
                            </thead>
                            <tbody>
                                @foreach ($member as $key => $item)
                                <tr>
                                    <td width="2%">{{ $key+1 }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->telepon }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>
                                        <a href="#" onclick="pilihMember('{{ $item->id_member }}', '{{ $item->nama }}')"
                                            class="btn btn-xs btn-primary"><i class="fa fa-plus-circle">
                                                Pilih</i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>