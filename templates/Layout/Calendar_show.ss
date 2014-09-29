<% loop CalendarEntry %>
	<div class="calendar-event">
		<h2 class="calendar-event-title">$Title</h1>
		<% if $PhotoSized %>
			<img src="$PhotoSized.URL" alt="title" class="event-img-full">
		<% end_if %>
		<dl class="calendar-event-details">
			<% if $NiceDates %>
				<span class="calendar-event-detail dates">
					<dt>Date:</dt>
					<dd>$NiceDates</dd>
				</span><!-- calendar-event-detail dates -->
			<% end_if %>
			<% if $NiceTimes %>
				<span class="calendar-event-detail times">
					<dt>Time:</dt>
					<dd>$NiceTimes</dd>
				</span><!-- calendar-event-detail times -->
			<% end_if %>
			<% if $Location %>
				<span class="calendar-event-detail location">
					<dt>Location:</dt>
					<dd>$Location</dd>
				</span><!-- calendar-event-detail location -->
			<% end_if %>
			<% if $Resource %>
				<span class="calendar-event-detail resource">
					<dt>Resource:</dt>
					<dd><a href="$Resource.URL">View/Download</a></dd>
				</span><!-- calendar-event-detail resource -->
			<% end_if %>
		</dl><!-- calendar-event-details -->
		<% if $Content %>
			<p>$Content</p>
		<% end_if %>
	</div><!-- calendar-event -->
	<p><a href="$CalendarLink" class="back-to-events button">&larr; Back to the Calendar</a></p>
<% end_loop %>
