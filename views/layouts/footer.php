</div>
            </main>
            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="footer-content">
                        <div class="footer-copyright">
                            <span>Copyright &copy; SysVentas <?php echo date('Y'); ?></span>
                        </div>
                        <div class="footer-links">
                            <a href="#" class="footer-link">
                                <i class="fas fa-shield-alt"></i> Política de privacidad
                            </a>
                            <span class="footer-divider">|</span>
                            <a href="#" class="footer-link">
                                <i class="fas fa-file-contract"></i> Términos &amp; Condiciones
                            </a>
                        </div>
                        <div class="footer-version">
                            <span>v1.2.0</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Footer Styles -->
    <style>
        .footer {
            background-color: #fff;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 -0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            padding: 1.5rem 0;
            position: relative;
        }
        
        .footer-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .footer-copyright {
            color: #858796;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .footer-links {
            display: flex;
            align-items: center;
        }
        
        .footer-link {
            color: #4e73df;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }
        
        .footer-link i {
            margin-right: 6px;
            font-size: 0.85rem;
        }
        
        .footer-link:hover {
            color: #224abe;
            text-decoration: none;
        }
        
        .footer-divider {
            margin: 0 10px;
            color: #d1d3e2;
        }
        
        .footer-version {
            color: #858796;
            font-size: 0.8rem;
            opacity: 0.6;
        }
        
        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                text-align: center;
            }
            
            .footer-copyright, .footer-links, .footer-version {
                margin-bottom: 0.8rem;
            }
            
            .footer-copyright, .footer-version {
                margin-bottom: 0.8rem;
            }
            
            .footer-links {
                flex-direction: column;
            }
            
            .footer-divider {
                display: none;
            }
            
            .footer-link {
                margin-bottom: 0.8rem;
            }
        }
    </style>
    
    <!-- jQuery Core -->
    <script src="<?php echo BASE_URL; ?>assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap Bundle JS -->
    <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    <!-- Core Theme JS -->
    <script src="<?php echo BASE_URL; ?>assets/js/scripts.js"></script>
    
    <!-- DataTables JS -->
    <script src="<?php echo BASE_URL; ?>assets/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    
    <!-- jQuery UI JS -->
    <script src="<?php echo BASE_URL; ?>assets/js/jquery-ui/jquery-ui.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="<?php echo BASE_URL; ?>assets/js/sweetalert2.all.min.js"></script>
    
    <!-- Custom Functions -->
    <script src="<?php echo BASE_URL; ?>assets/js/functions.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/autocompletado.js"></script>
    
    <!-- Active Link Highlighting -->
    <script>
        $(document).ready(function() {
            // Highlight current page in sidebar
            const currentUrl = window.location.href;
            $('.sb-sidenav .nav-link').each(function() {
                const linkUrl = $(this).attr('href');
                if (currentUrl.includes(linkUrl) && linkUrl !== BASE_URL + 'Dashboard') {
                    $(this).addClass('active');
                } else if (currentUrl === BASE_URL || currentUrl === BASE_URL + 'Dashboard') {
                    $('.sb-sidenav .nav-link:first').addClass('active');
                }
            });
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Initialize Select2 components
            if($.fn.select2) {
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            }
        });
    </script>
</body>
</html> 