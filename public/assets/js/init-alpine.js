function data() {
  function getThemeFromLocalStorage() {
    // if user already changed the theme, use it
    if (window.localStorage.getItem('dark')) {
      return JSON.parse(window.localStorage.getItem('dark'))
    }

    // else return their preferences
    return (
      !!window.matchMedia &&
      window.matchMedia('(prefers-color-scheme: dark)').matches
    )
  }

  function setThemeToLocalStorage(value) {
    window.localStorage.setItem('dark', value)
  }

  return {
    dark: getThemeFromLocalStorage(),
    toggleTheme() {
      this.dark = !this.dark
      setThemeToLocalStorage(this.dark)
    },
    isSideMenuOpen: false,
    toggleSideMenu() {
      this.isSideMenuOpen = !this.isSideMenuOpen
    },
    closeSideMenu() {
      this.isSideMenuOpen = false
    },
    isNotificationsMenuOpen: false,
    toggleNotificationsMenu() {
      this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
    },
    closeNotificationsMenu() {
      this.isNotificationsMenuOpen = false
    },
    isProfileMenuOpen: false,
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen
    },
    closeProfileMenu() {
      this.isProfileMenuOpen = false
    },
}
}

function dataSidebarDropDownMenu() {
    return {
            isPagesMenuOpen: false,
            togglePagesMenu() {
                this.isPagesMenuOpen = !this.isPagesMenuOpen
            }
        }
}


function fileUpload() {
    return {
        imagePreview: null,
        isDragging: false,
        isUploading: false,
        progress: 0,
        timeToUpload: 1,
        uploadSpeed: null,
        fileName: null,
        showPreview(event) {
            const file = event.target.files[0];
            this.setImagePreview(file);
        },

        handleDrop(event) {
            this.isDragging = false;
            const file = event.dataTransfer.files[0];
            this.setImagePreview(file);
        },

        async setImagePreview(file) {
          if (file) 
            {
              if (!this.uploadSpeed) {
                this.uploadSpeed = await this.measureUploadSpeed();
              }

              // Calculate the time to upload based on size and speed
              if (this.isUploading) {
                this.resetUploadState();
              }
              // Start new upload process
              setTimeout(()=> {
                this.isUploading = true;    
              }, 300)
              
              const fileSizeInBytes = file.size;
              this.timeToUpload = fileSizeInBytes / this.uploadSpeed;
              this.simulateUpload();
              
              this.fileName = file.name;
              if (file.type.startsWith('image/')) {
                  this.imagePreview = URL.createObjectURL(file);
              } else {
                  this.imagePreview = null;
              }
          }
        },

        resetUploadState() {
          this.isUploading = false;
          this.progress = 0;
          this.timeToUpload = 0;
          this.imagePreview = null;
          this.fileName = null;
        },

        simulateUpload() {
          const interval = setInterval(() => {
              if (this.progress < 100) {
                  this.progress += 10;
              } else {
                  clearInterval(interval);
              }
          }, this.timeToUpload * 100); // Adjust interval timing
        },

        async measureUploadSpeed() {
          const testBlob = new Blob([".".repeat(1024 * 1024)], { type: "text/plain" });
          const fileSizeInBytes = testBlob.size;
      
          const startTime = performance.now();
      
          try {
              const response = await fetch("https://httpbin.org/post", {
                  method: "POST",
                  body: testBlob,
              });
      
              const endTime = performance.now();
              const timeTakenInSeconds = (endTime - startTime) / 1000;
      
              if (response.ok) {
                  const uploadSpeed = fileSizeInBytes / timeTakenInSeconds;
                  console.log(`Upload Speed: ${(uploadSpeed / 1_000_000).toFixed(2)} MB/s`);
                  return uploadSpeed;
              } else {
                  console.error("Failed to measure upload speed.");
                  return null;
              }
          } catch (error) {
              console.error("Error during upload speed measurement:", error);
              return null;
          }
      }
    };
}
