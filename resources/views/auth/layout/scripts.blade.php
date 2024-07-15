 <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
 <script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
 <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
 <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>

 <!-- END GLOBAL MANDATORY SCRIPTS -->
 <script src="{{ asset('assets/js/authentication/form-2.js') }}"></script>

 {{-- BEGIN PLUGIN --}}
 <script src="{{ asset('feather/feather.min.js') }}"></script>
 <script>
     feather.replace();

 </script>

 @yield('script')
 {{-- END BEGIN PLUGIN --}}

 <script>
     let deferredPrompt;

     window.addEventListener('beforeinstallprompt', (e) => {
         // Stash the event so it can be triggered later.
         deferredPrompt = e;
         // Update UI notify the user they can install the PWA
         const installButton = document.getElementById('installButton');
         installButton.style.display = 'block';

         installButton.addEventListener('click', (e) => {
             // Hide the install button
             installButton.style.display = 'none';
             // Show the install prompt
             deferredPrompt.prompt();
             // Wait for the user to respond to the prompt
             deferredPrompt.userChoice.then((choiceResult) => {
                 if (choiceResult.outcome === 'accepted') {
                     console.log('User accepted the install prompt');
                 } else {
                     console.log('User dismissed the install prompt');
                 }
                 deferredPrompt = null;
             });
         });

     });

     window.addEventListener('appinstalled', (evt) => {
         console.log('a2hs', 'installed');
         // Hide the install button if the app is installed
         document.getElementById('installButton').style.display = 'none';
     });

 </script>
