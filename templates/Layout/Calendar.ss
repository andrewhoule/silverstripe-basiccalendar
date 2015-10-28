<% if $Content %>$Content<% end_if %>
<% if $PaginatedUpcomingEvents %>
  <div class="upcoming-events-wrap">
    <ul class="upcoming-events">
      <% loop $PaginatedUpcomingEvents %>
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
              <% if $ContentExcerpt %>
                <span class="excerpt">$ContentExcerpt(300) <a href="$Link" class="more">Read on</a></span>
              <% end_if %>
            <% end_if %>
          </div><!-- .event-info -->
        </li><!-- upcoming-event -->
      <% end_loop %>
    </ul><!-- upcoming-events -->
  </div><!-- upcoming events-wrap -->
<% else %>
  <p class="no-events">There are no upcoming events at the moment. Please check back soon.</p><!-- .no-events -->
<% end_if %>
<% if $PaginatedUpcomingEvents.MoreThanOnePage %>
  <ul class="pagination">
    <% loop $PaginatedUpcomingEvents.PaginationSummary %>
      <% if $Link %>
        <li <% if $CurrentBool %>class="active"<% end_if %>><a href="$Link">$PageNum</a></li>
      <% else %>
        <li>...</li>
      <% end_if %>
    <% end_loop %>
  </ul><!-- pagination -->
<% end_if %>