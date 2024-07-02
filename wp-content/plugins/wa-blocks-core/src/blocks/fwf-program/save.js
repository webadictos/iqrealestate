import { useBlockProps, RichText } from '@wordpress/block-editor';

const save = props => {
  const { attributes } = props;
  const { schedule } = attributes;

  return (
    <div {...useBlockProps.save()}>
      {schedule.map((day, dayIndex) => (
        <div
          key={dayIndex}
          className="wp-block-fw-festival-2024-fwf-program__day-container"
        >
          <RichText.Content
            tagName="h2"
            value={day.day}
            className="wp-block-fw-festival-2024-fwf-program__day-heading"
          />
          {day.events.map((event, eventIndex) => (
            <div
              key={eventIndex}
              className="wp-block-fw-festival-2024-fwf-program__event-container"
            >
              <RichText.Content
                tagName="h3"
                value={event.event}
                className="wp-block-fw-festival-2024-fwf-program__event-heading"
              />
              {event.activities.map((activity, activityIndex) => (
                <div
                  key={activityIndex}
                  className="wp-block-fw-festival-2024-fwf-program__activity-schedule"
                >
                  <RichText.Content
                    tagName="p"
                    value={activity.time}
                    className="wp-block-fw-festival-2024-fwf-program__activity-time"
                  />
                  <RichText.Content
                    tagName="p"
                    value={activity.activity}
                    className="wp-block-fw-festival-2024-fwf-program__activity-desc"
                  />
                </div>
              ))}
            </div>
          ))}
        </div>
      ))}
    </div>
  );
};

export default save;
