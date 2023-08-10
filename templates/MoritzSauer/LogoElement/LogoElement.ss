<div class="logoelement">
    <div class="typography">
        <div class="swiper-container" id="LogoElement{$ID}">
            <div class="swiper-wrapper">
                <% loop $sortedLogos %>
                    <div class="swiper-slide">
                        <div class="logo__item my-3 my-md-4">
                            <% if $ExternalLink || $showModal %>
                                <% if $showModal %>
                                    <span data-bs-toggle="modal" data-bs-target="#logo__content{$ID}">
                                <% else %>
                                    <a href="$ExternalLink" target="_blank">
                                <% end_if %>
                            <% end_if %>
                                <img src="$Logo.Fit(250,50).Link" class="logo__item--logo default">
                                <% if $ColoredLogo %>
                                    <img src="$Logo.Fit(250,50).Link" class="logo__item--logo color">
                                <% end_if %>
                            <% if $showModal %>
                                </span>
                            <% else_if $ExternalLink %>
                                </a>
                            <% end_if %>
                        </div>
                    </div>
                <% end_loop %>
            </div>
        </div>
        <% loop $sortedLogos %>
            <% if $showModal %>
                <div class="modal fade" id="logo__content{$ID}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <% if $ColoredLogo %>
                                    <img src="$Logo.Fit(250,50).Link" class="logo__content--logo color">
                                <% end_if %>
                                <% if $Title %>
                                    <h5>
                                        $Title
                                    </h5>
                                <% end_if %>
                                <% if $ExternalLink %>
                                    <a href="$ExternalLink" target="_blank">
                                        $cleanedExternalLink
                                    </a>
                                <% end_if %>
                                $Content
                                <% if $showImage %>
                                    <img src="$Image.FocusFill(450,300).Link" class="img-fluid logo__content--image">
                                <% end_if %>
                            </div>
                        </div>
                    </div>
                </div>
            <% end_if %>
        <% end_loop %>
    </div>
</div>