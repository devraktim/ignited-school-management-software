                                </div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
						<!--begin::Footer-->
							<?php $this->load->view("inc/footer/index.php") ?>
						<!--end::Footer-->
					</div>
					<!--end:::Main-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->


		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
			<span class="svg-icon">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->
		
        
		<script>
            // Function to change the text if it matches 'ST. Joseph\'s Convent School'
            function changeTextToDemo() {
                // Find the div element
                const div = document.querySelector('div');
                
                // Check if the div's text content is exactly 'ST. Joseph\'s Convent School'
                if (div.textContent.trim() === "ST. Joseph's Convent School") {
                    // Change its text content to 'demo text'
                    div.textContent = 'demo text';
                }
            }
        
            // Call the function to change text
            changeTextToDemo();
		</script>
		<script src="<?php echo base_url() ?>assets/plugins/global/plugins.bundle.js"></script>
		<script src="<?php echo base_url() ?>assets/js/scripts.bundle.js"></script>
		<script src="<?php echo base_url() ?>assets/js/widgets.bundle.js"></script>
		<script src="<?php echo base_url() ?>assets/js/custom/widgets.js"></script>
		<script src="<?php echo base_url() ?>assets/js/custom/apps/chat/chat.js"></script>
		<script src="<?php echo base_url() ?>assets/js/custom/utilities/modals/upgrade-plan.js"></script>
		<script src="<?php echo base_url() ?>assets/js/custom/utilities/modals/create-app.js"></script>
		<script src="<?php echo base_url() ?>assets/js/custom/utilities/modals/new-target.js"></script>
		<script src="<?php echo base_url() ?>assets/js/custom/utilities/modals/users-search.js"></script>
		<script src="<?php echo base_url() ?>assets/js/script.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/tablednd@1.0.5/dist/jquery.tablednd.min.js"></script>
        <script src="https://unpkg.com/bootstrap-table@1.22.0/dist/bootstrap-table.min.js"></script>
        <script src="https://unpkg.com/bootstrap-table@1.22.0/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.min.js"></script>
	</body>
</html>