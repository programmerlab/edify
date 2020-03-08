<!DOCTYPE html>
<html>

@include('dashboard.partials.head')
<script>
        
        var processGraphs = document.querySelectorAll('.process polygon');
        var processDetails = document.querySelectorAll('.process-details > div');
        var processGraphMouseover = function (event) {
            for (var pg = 0, pgl = processGraphs.length; pg < pgl; pg++) {
                if (processGraphs[pg] === event.target && event.type === 'mouseover') {
                    processGraphs[pg].style.opacity = 1;
                } else {
                    processGraphs[pg].style.opacity = 0.5;
                }
            }
            for (pd = 0, pdl = processDetails.length; pd < pdl; pd++) {
                if (processDetails[pd].classList.contains(event.target.getAttribute('class')) && event.type === 'mouseover') {
                    processDetails[pd].style.opacity = 1;
                } else {
                    processDetails[pd].style.opacity = 0.5;
                }
            }
        };
        var processGraphMouseout = function (event) {
            for (var pg = 0, pgl = processGraphs.length; pg < pgl; pg++) {
                processGraphs[pg].removeAttribute('style');
            }
            for (pd = 0, pdl = processDetails.length; pd < pdl; pd++) {
                processDetails[pd].removeAttribute('style');
            }
        };
        for (var pg = 0, pgl = processGraphs.length; pg < pgl; pg++) {
            processGraphs[pg].addEventListener('mouseover', processGraphMouseover);
            processGraphs[pg].addEventListener('mouseout', processGraphMouseout);
        }
            </script>
<body class="theme-edify1">

@include('dashboard.partials.header')

<section>

@include('dashboard.partials.sidebar')

</section>

<section class="content">
        <div class="container-fluid">

        <div class="section">
                <div class="body">
                    <h2>Terms and Conditions</h2>
                    <p>These terms and conditions (&quot;Terms&quot;, &quot;Agreement&quot;) are an agreement between Website Operator (&quot;Website Operator&quot;, &quot;us&quot;, &quot;we&quot; or &quot;our&quot;) and you (&quot;User&quot;, &quot;you&quot; or &quot;your&quot;). This Agreement sets forth the general terms and conditions of your use of the <a target="_blank" rel="nofollow" href="http://edify.com">edify.com</a> website and any of its products or services (collectively, &quot;Website&quot; or &quot;Services&quot;).</p>
                    <h4>Accounts and membership</h4>
                    <p>You must be at least 13 years of age to use this Website. By using this Website and by agreeing to this Agreement you warrant and represent that you are at least 13 years of age. If you create an account on the Website, you are responsible for maintaining the security of your account and you are fully responsible for all activities that occur under the account and any other actions taken in connection with it. We may, but have no obligation to, monitor and review new accounts before you may sign in and use our Services. Providing false contact information of any kind may result in the termination of your account. You must immediately notify us of any unauthorized uses of your account or any other breaches of security. We will not be liable for any acts or omissions by you, including any damages of any kind incurred as a result of such acts or omissions. We may suspend, disable, or delete your account (or any part thereof) if we determine that you have violated any provision of this Agreement or that your conduct or content would tend to damage our reputation and goodwill. If we delete your account for the foregoing reasons, you may not re-register for our Services. We may block your email address and Internet protocol address to prevent further registration.</p>
                    <h4>User content</h4>
                    <p>We do not own any data, information or material (&quot;Content&quot;) that you submit on the Website in the course of using the Service. You shall have sole responsibility for the accuracy, quality, integrity, legality, reliability, appropriateness, and intellectual property ownership or right to use of all submitted Content. We may monitor and review Content on the Website submitted or created using our Services by you. Unless specifically permitted by you, your use of the Website does not grant us the license to use, reproduce, adapt, modify, publish or distribute the Content created by you or stored in your user account for commercial, marketing or any similar purpose. But you grant us permission to access, copy, distribute, store, transmit, reformat, display and perform the Content of your user account solely as required for the purpose of providing the Services to you. Without limiting any of those representations or warranties, we have the right, though not the obligation, to, in our own sole discretion, refuse or remove any Content that, in our reasonable opinion, violates any of our policies or is in any way harmful or objectionable.</p>
                    <h4>Backups</h4>
                    <p>We are not responsible for Content residing on the Website. In no event shall we be held liable for any loss of any Content. It is your sole responsibility to maintain appropriate backup of your Content. Notwithstanding the foregoing, on some occasions and in certain circumstances, with absolutely no obligation, we may be able to restore some or all of your data that has been deleted as of a certain date and time when we may have backed up data for our own purposes. We make no guarantee that the data you need will be available.</p>
                    <h4>Links to other websites</h4>
                    <p>Although this Website may link to other websites, we are not, directly or indirectly, implying any approval, association, sponsorship, endorsement, or affiliation with any linked website, unless specifically stated herein. Some of the links on the Website may be &quot;affiliate links&quot;. This means if you click on the link and purchase an item, Website Operator will receive an affiliate commission. We are not responsible for examining or evaluating, and we do not warrant the offerings of, any businesses or individuals or the content of their websites. We do not assume any responsibility or liability for the actions, products, services, and content of any other third-parties. You should carefully review the legal statements and other conditions of use of any website which you access through a link from this Website. Your linking to any other off-site websites is at your own risk.</p>
                    <h4>Limitation of liability</h4>
                    <p>To the fullest extent permitted by applicable law, in no event will Website Operator, its affiliates, officers, directors, employees, agents, suppliers or licensors be liable to any person for (a): any indirect, incidental, special, punitive, cover or consequential damages (including, without limitation, damages for lost profits, revenue, sales, goodwill, use of content, impact on business, business interruption, loss of anticipated savings, loss of business opportunity) however caused, under any theory of liability, including, without limitation, contract, tort, warranty, breach of statutory duty, negligence or otherwise, even if Website Operator has been advised as to the possibility of such damages or could have foreseen such damages. To the maximum extent permitted by applicable law, the aggregate liability of Website Operator and its affiliates, officers, employees, agents, suppliers and licensors, relating to the services will be limited to an amount greater of one dollar or any amounts actually paid in cash by you to Website Operator for the prior one month period prior to the first event or occurrence giving rise to such liability. The limitations and exclusions also apply if this remedy does not fully compensate you for any losses or fails of its essential purpose.</p>
                    <h4>Changes and amendments</h4>
                    <p>We reserve the right to modify this Agreement or its policies relating to the Website or Services at any time, effective upon posting of an updated version of this Agreement on the Website. When we do, we will revise the updated date at the bottom of this page. Continued use of the Website after any such changes shall constitute your consent to such changes. Policy was created with <a style="color:inherit" target="_blank" title="Terms and conditions generator" href="https://www.websitepolicies.com/blog/sample-terms-conditions-template">WebsitePolicies</a>.</p>
                    <h4>Acceptance of these terms</h4>
                    <p>You acknowledge that you have read this Agreement and agree to all its terms and conditions. By using the Website or its Services you agree to be bound by this Agreement. If you do not agree to abide by the terms of this Agreement, you are not authorized to use or access the Website and its Services.</p>
                    <h4>Contacting us</h4>
                    <p>If you would like to contact us to understand more about this Agreement or wish to contact us concerning any matter relating to it, you may send an email to &#105;n&#102;o&#64;&#101;&#100;&#105;fy.&#99;om</p>
                    <p>This document was last updated on March 7, 2020</p>
                </div>
            </div>

        </div>
</section>

@include('dashboard.partials.footer_links')
</body>

</html>
