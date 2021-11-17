<!-- Modal -->
<div class="modal fade" id="modalDetailImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelImage">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-2-tab" data-toggle="tab"
                                href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                                aria-selected="false"><i class="i fas fa-info mr-2"></i>Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-1-tab" data-toggle="tab"
                                href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1"
                                aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i>New Image</a>
                        </li>
                    </ul>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-icons-text-2" role="tabpanel"
                                aria-labelledby="tabs-icons-text-2-tab">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <img id="imageDetail"
                                                src="{{ asset('/storage/productImgs/' . 'prod1.jpg') }}"
                                                class="img-fluid mx-auto d-block" alt="Responsive image">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-1" role="tabpanel"
                                aria-labelledby="tabs-icons-text-1-tab">

                                <form action="{{ route('produk.image.update') }}" method="post" id="form-update-imgProd" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="kodeProduk" id="kodeProduk">

                                    <input type="hidden" name="oldImgProd" id="oldImgProd" class="d-none">
                                    <input type="file" name="newImgProd" id="newImgProd" class="d-none">
                                    <img id="imageDetail"
                                                onclick="$('#newImgProd').click()"
                                                src="{{ asset('/storage/productImgs/' . 'prod1.jpg') }}"
                                                class="img-fluid mx-auto d-block updateImgProduct" alt="Responsive image">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
