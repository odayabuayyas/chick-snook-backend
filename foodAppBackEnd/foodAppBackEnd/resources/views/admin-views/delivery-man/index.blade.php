@extends('layouts.admin.app')

@section('title', translate('Add new delivery-man'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/deliveryman.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('add_New_Deliveryman')}}
                </span>
            </h2>
        </div>

        <div class="row g-2">
            <div class="col-12">
                <form action="{{route('admin.delivery-man.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 d-flex align-items-center gap-2 mb-0">
                                <i class="tio-user"></i>
                                {{translate('General_Information')}}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('first_Name')}}</label>
                                        <input value="{{old('f_name')}}" type="text" name="f_name" class="form-control" placeholder="{{translate('first_Name')}}"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('last_Name')}}</label>
                                        <input value="{{ old('l_name') }}" type="text" name="l_name" class="form-control" placeholder="{{translate('last_Name')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="input-label">{{translate('identity_Type')}}</label>
                                        <select name="identity_type" class="form-control">
                                            <option value="passport">{{translate('passport')}}</option>
                                            <option value="driving_license">{{translate('driving')}} {{translate('license')}}</option>
                                            <option value="nid">{{translate('nid')}}</option>
                                            <option value="restaurant_id">{{translate('restaurant')}} {{translate('id')}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="input-label">{{translate('identity_Number')}}</label>
                                        <input value="{{old('identity_number')}}" type="text" name="identity_number" class="form-control"
                                            placeholder="{{translate('Ex : DH-23434-LS')}}"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label class="input-label">{{translate('identity_Image')}}</label>
                                        <div>
                                            <div class="row" id="coba"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('phone')}}</label>
                                        <input value="{{old('phone')}}" type="text" name="phone" class="form-control" placeholder="{{translate('Ex : 017********')}}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label">{{translate('branch')}}</label>
                                        <select name="branch_id" class="form-control">
                                            <option value="0">{{translate('all')}}</option>
                                            @foreach(\App\Model\Branch::all() as $branch)
                                                <option value="{{$branch['id']}}">{{$branch['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{translate('deliveryman_Image')}}</label>
                                        <small class="text-danger">* ( {{translate('ratio')}} 1:1 )</small>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                            <label class="custom-file-label" for="customFileEg1">{{translate('choose_File')}}</label>
                                        </div>
                                        <center class="mt-3">
                                            <img class="upload-img-view" id="viewer"
                                                src="{{asset('public/assets/admin/img/160x160/img1.jpg')}}" alt="{{translate('delivery-man image')}}"/>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0 d-flex align-items-center gap-2 mb-0">
                                <i class="tio-user"></i>
                                {{translate('Account_Information')}}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('email')}}</label>
                                        <input value="{{old('email')}}" type="email" name="email" class="form-control" placeholder="{{translate('Ex : ex@example.com')}}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('password')}}</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="password" class="js-toggle-password form-control form-control input-field" id="password"
                                                   placeholder="{{translate('Ex: 8+ Characters')}}" required
                                                   data-hs-toggle-password-options='{
                                                "target": "#changePassTarget",
                                                "defaultClass": "tio-hidden-outlined",
                                                "showClass": "tio-visible-outlined",
                                                "classChangeTarget": "#changePassIcon"
                                                }'>
                                            <div id="changePassTarget" class="input-group-append">
                                                <a class="input-group-text" href="javascript:">
                                                    <i id="changePassIcon" class="tio-visible-outlined"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label">{{translate('confirm_password')}}</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="confirm_password" class="js-toggle-password form-control form-control input-field"
                                                   id="confirm_password" placeholder="{{translate('confirm password')}}" required
                                                   data-hs-toggle-password-options='{
                                                "target": "#changeConPassTarget",
                                                "defaultClass": "tio-hidden-outlined",
                                                "showClass": "tio-visible-outlined",
                                                "classChangeTarget": "#changeConPassIcon"
                                                }'>
                                            <div id="changeConPassTarget" class="input-group-append">
                                                <a class="input-group-text" href="javascript:">
                                                    <i id="changeConPassIcon" class="tio-visible-outlined"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-end mt-3">
                        <button type="reset" id="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                        <button type="submit" class="btn btn-primary">{{translate('submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script src="{{asset('public/assets/admin/js/read-url.js')}}"></script>
    <script src="{{asset('public/assets/admin/js/spartan-multi-image-picker.js')}}"></script>
    <script>
        "use strict";

        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '230px',
                groupClassName: 'col-6 col-lg-4',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/admin/img/400x400/img2.jpg')}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{translate("Please only input png or jpg type file")}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{translate("File size too big")}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        $('.js-toggle-password').each(function () {
            new HSTogglePassword(this).init()
        });

        $(document).on('ready', function () {
            $('.js-toggle-password').each(function () {
                new HSTogglePassword(this).init()
            });

            $('.js-validate').each(function () {
                $.HSCore.components.HSValidation.init($(this));
            });
        });
    </script>
@endpush
