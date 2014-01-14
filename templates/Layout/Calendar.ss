<% if Content %>$Content<% end_if %>
<% if PaginatedUpcomingEvents %>
    <div class="upcoming-events-wrap">
        <ul class="upcoming-events">
            <% loop PaginatedUpcomingEvents %>
                <li class="upcoming-event">
                    <% if PhotoCropped %><img src="$PhotoCropped(70,70).URL" alt="$Title" class="event-img-thumb"><% end_if %>
                    <span class="dates">$NiceDates</span>
                    <span class="title"><a href="$Link">$Title</a></span>
                </li><!-- upcoming-event -->
            <% end_loop %>
        </ul><!-- upcoming-events -->
    </div><!-- upcoming events-wrap -->
<% end_if %>
<% if PaginatedUpcomingEvents.MoreThanOnePage %>
    <div class="pagination-wrap cf">
    <ul id="pagination">   
        <% if PaginatedUpcomingEvents.NotFirstPage %>
            <li class="previous"><a title="<% _t('VIEWPREVIOUSPAGE','View the previous page') %>" href="$PaginatedUpcomingEvents.PrevLink"><% _t('PREVIOUS','&larr;') %></a></li>       
        <% else %>  
            <li class="previous-off"><% _t('PREVIOUS','&larr;') %></li>
        <% end_if %>
        <% loop PaginatedUpcomingEvents.Pages %>
            <% if CurrentBool %>
                <li class="active">$PageNum</li>
            <% else %>
                <li><a href="$Link" title="<% sprintf(_t('VIEWPAGENUMBER','View page number %s'),$PageNum) %>">$PageNum</a></li>        
            <% end_if %>
        <% end_loop %>
        <% if PaginatedUpcomingEvents.NotLastPage %>
            <li class="next"><a title="<% _t('VIEWNEXTPAGE', 'View the next page') %>" href="$PaginatedUpcomingEvents.NextLink"><% _t('NEXT','&rarr;') %></a></li>
        <% else %>
            <li class="next-off"><% _t('NEXT','&rarr;') %> </li>        
        <% end_if %>
    </ul>   
    </div><!-- pagination-wrap cf -->
<% end_if %>