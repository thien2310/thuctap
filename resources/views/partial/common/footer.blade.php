            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

            </div>
            <!-- {!! Toastr::message() !!} -->

            <!-- Bootstrap core JavaScript-->
            <!-- <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script> -->
            <script src="{{asset('BE/adminTle/vendor/jquery/jquery.min.js')}}"></script>
            <script src="{{asset('BE/adminTle/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

            <!-- Core plugin JavaScript-->
            <script src="{{asset('BE/adminTle/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
            @yield('script')
            <!-- Custom scripts for all pages-->
            <script src="{{asset('BE/adminTle/js/sb-admin-2.min.js')}}"></script>
            <!-- <script src="{{asset('BE/libs/angular/angular.js')}}"></script> -->
            <!-- <script src="{{asset('BE/js/app.js')}}"></script> -->
            <!-- <script src="{{asset('BE/js/angular-sanitize.js')}}"></script> -->

            <!-- <script src="{{asset('BE/js/select.js')}}"></script> -->
            <!-- <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

            <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>


            <script type="text/javascript">
                @if(Session::has('message'))
                toastr. {
                    {
                        Session::get('alert-type', 'success')
                    }
                }("{{Session::get('message')}}", 'Thành công');

                @endif
                @if(Session::has('warning'))

                toastr. {
                    {
                        Session::get('alert-type', 'warning')
                    }
                }("{{Session::get('warning')}}", 'Thất bại !!');
                @endif
            </script>

            <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            </script>


            </body>

            </html>
