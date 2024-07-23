 <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
 <script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
 <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
 <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>

 <!-- END GLOBAL MANDATORY SCRIPTS -->
 <script src="{{ asset('assets/js/authentication/form-2.js') }}"></script>

 {{-- BEGIN PLUGIN --}}
 <script src="{{ asset('feather/feather.min.js') }}"></script>
 <script>
     feather.replace()

 </script>

 @yield('script')
 {{-- END BEGIN PLUGIN --}}

 <script>
     let deferredPrompt

     window.addEventListener('beforeinstallprompt', (e) => {
         //  e.preventDefault()
         deferredPrompt = e
     })

     const installButton = document.getElementById('installButton')
     const installWrap = document.getElementById('installWrap')

     if (installButton) {
         function updateInstallButton() {
             if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
                 installButton.textContent = 'Installed'
                 installWrap.style.display = 'none'
             } else {
                 installButton.textContent = 'Install'
                 installWrap.style.display = 'block'
             }
         }

         installButton.addEventListener('click', async () => {
             if (installButton.textContent === 'Installed') {
                 return
             }

             if (deferredPrompt) {
                 deferredPrompt.prompt()
                 const {
                     outcome
                 } = await deferredPrompt.userChoice
                 if (outcome === 'accepted') {
                     installButton.textContent = 'Installed'
                     installWrap.style.display = 'none'
                 } else {
                     installButton.textContent = 'Install'
                 }
                 deferredPrompt = null
             }
         })

         updateInstallButton()
         window.matchMedia('(display-mode: standalone)').addEventListener('change', updateInstallButton)
     }

 </script>
