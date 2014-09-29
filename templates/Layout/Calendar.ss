<% if $Content %>$Content<% end_if %>
<% if $PaginatedUpcomingEvents %>
    <div class="upcoming-events-wrap">
        <ul class="upcoming-events">
            <% loop PaginatedUpcomingEvents %>
                <li class="upcoming-event">
                    <% if $PhotoCropped %>
                        <div class="event-thumb">
                          <img src="$PhotoCropped.URL" alt="$Title" class="event-img-thumb">  
                        </div><!-- .event-thumb -->
                    <% end_if %>
                    <div class="event-info">
                        <% if $NiceDates %><span class="dates">$NiceDates</span><% end_if %>
                        <% if $NiceTimes %><span class="times">$NiceTimes</span><% end_if %>
                        <% if $Title %><span class="title"><a href="$Link">$Title</a></span><% end_if %>
                        <% if $Up.ShowExcerpt %>
                            <span class="excerpt">$ContentExcerpt(300) <a href="$Link" class="more">Read on</a></span>
                        <% end_if %>
                    </div><!-- .event-info -->
                </li><!-- upcoming-event -->
            <% end_loop %>
        </ul><!-- upcoming-events -->
    </div><!-- upcoming events-wrap -->
<% end_if %>
<% if $PaginatedUpcomingEvents.MoreThanOnePage %>
    <div class="pagination-wrap cf">
    <ul id="pagination">   
        <% if $PaginatedUpcomingEvents.NotFirstPage %>
            <li class="previous"><a title="<% _t('VIEWPREVIOUSPAGE','View the previous page') %>" href="$PaginatedUpcomingEvents.PrevLink"><% _t('PREVIOUS','&larr;') %></a></li>       
        <% else %>  
            <li class="previous-off"><% _t('PREVIOUS','&larr;') %></li>
        <% end_if %>
        <% loop PaginatedUpcomingEvents.Pages %>
            <% if $CurrentBool %>
                <li class="active">$PageNum</li>
            <% else %>
                <li><a href="$Link" title="<% sprintf(_t('VIEWPAGENUMBER','View page number %s'),$PageNum) %>">$PageNum</a></li>        
            <% end_if %>
        <% end_loop %>
        <% if $PaginatedUpcomingEvents.NotLastPage %>
            <li class="next"><a title="<% _t('VIEWNEXTPAGE', 'View the next page') %>" href="$PaginatedUpcomingEvents.NextLink"><% _t('NEXT','&rarr;') %></a></li>
        <% else %>
            <li class="next-off"><% _t('NEXT','&rarr;') %> </li>        
        <% end_if %>
    </ul>   
    </div><!-- pagination-wrap cf -->
<% end_if %>