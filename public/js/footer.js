          document.getElementById('subscribeForm').addEventListener('submit', function(event) {
                event.preventDefault();
                document.getElementById('thankYouMessage').style.display = 'block';
            });
              // Hide loading spinner when content is loaded
          document.addEventListener('DOMContentLoaded', function() {
              document.getElementById('loadingSpinner').style.display = 'none';
          });

              // Scroll to Top Button
              function topFunction() {
                  document.body.scrollTop = 0;
                  document.documentElement.scrollTop = 0;
              }

              // Show/Hide Scroll to Top Button
              window.onscroll = function() {
                  const myBtn = document.getElementById('myBtn');
                  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                      myBtn.style.display = "block";
                  } else {
                      myBtn.style.display = "none";
                  }
              };

          // Toggle Mobile Menu
          function toggleMobileMenu() {
              const menu = document.getElementById('mobileMenu');
              menu.classList.toggle('active');
              document.body.classList.toggle('no-scroll');
          }

          // Toggle Mega Menu (Desktop)
          function toggleMegaMenu() {
              const megaMenu = document.getElementById('megaMenu');
              megaMenu.classList.toggle('active');
          }
    // Form submission handling
        document.getElementById('subscribeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const email = formData.get('email');
            
            // Simple email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                return;
            }
            
            // Show success message
            const successMessage = document.getElementById('thankYouMessage');
            successMessage.style.display = 'flex';
            
            // Add confetti effect
            createConfetti();
            
            // Simulate API call
            setTimeout(() => {
                console.log('Subscribed email:', email);
                // Here you would typically send data to your server
                // fetch('/subscribe', {
                //     method: 'POST',
                //     body: formData
                // }).then(response => response.json())
                //   .then(data => {
                //       console.log('Success:', data);
                //   });
            }, 500);
            
            // Reset form
            this.reset();
            
            // Auto-hide success message after 5 seconds
            setTimeout(hideSuccessMessage, 5000);
        });
        
        // Hide success message
        function hideSuccessMessage() {
            const successMessage = document.getElementById('thankYouMessage');
            successMessage.style.animation = 'slideIn 0.5s ease reverse';
            setTimeout(() => {
                successMessage.style.display = 'none';
                successMessage.style.animation = '';
            }, 500);
        }
        
        // Confetti effect for subscription success
        function createConfetti() {
            const colors = ['#ff6b6b', '#2e2bb1', '#791291', '#2ecc71', '#f1c40f'];
            const confettiCount = 50;
            
            for (let i = 0; i < confettiCount; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.cssText = `
                    position: fixed;
                    width: ${Math.random() * 10 + 5}px;
                    height: ${Math.random() * 10 + 5}px;
                    background: ${colors[Math.floor(Math.random() * colors.length)]};
                    border-radius: ${Math.random() > 0.5 ? '50%' : '0'};
                    top: 50%;
                    left: 50%;
                    z-index: 9999;
                    opacity: 0.8;
                    transform: rotate(${Math.random() * 360}deg);
                    animation: confettiFall ${Math.random() * 2 + 1}s ease-out forwards;
                `;
                
                document.body.appendChild(confetti);
                
                // Random direction
                const angle = Math.random() * Math.PI * 2;
                const velocity = 50 + Math.random() * 50;
                const vx = Math.cos(angle) * velocity;
                const vy = Math.sin(angle) * velocity;
                
                confetti.animate([
                    { 
                        transform: `translate(0, 0) rotate(0deg)`,
                        opacity: 1 
                    },
                    { 
                        transform: `translate(${vx}px, ${vy}px) rotate(${Math.random() * 360}deg)`,
                        opacity: 0 
                    }
                ], {
                    duration: 1000 + Math.random() * 1000,
                    easing: 'cubic-bezier(0.215, 0.610, 0.355, 1)'
                }).onfinish = () => confetti.remove();
            }
        }
        
        // Add CSS for confetti
        const style = document.createElement('style');
        style.textContent = `
            @keyframes confettiFall {
                0% { transform: translate(0, 0) rotate(0deg); opacity: 1; }
                100% { transform: translate(var(--x), 100vh) rotate(360deg); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
        
        // Logo click animation
        document.querySelector('.logo-wrapper').addEventListener('click', function(e) {
            if (e.target.closest('a')) {
                const logo = this.querySelector('.footer-logo');
                logo.style.animation = 'none';
                setTimeout(() => {
                    logo.style.animation = 'pulse 0.5s ease';
                }, 10);
            }
        });
        
        // Add pulse animation for logo
        const logoStyle = document.createElement('style');
        logoStyle.textContent = `
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.1); }
                100% { transform: scale(1); }
            }
        `;
        document.head.appendChild(logoStyle);