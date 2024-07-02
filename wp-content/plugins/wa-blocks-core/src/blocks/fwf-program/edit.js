import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Button, PanelBody, TextControl } from '@wordpress/components';
import { useState } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

const Edit = props => {
  const { attributes, setAttributes } = props;
  const { schedule } = attributes;

  const addDay = () => {
    const newSchedule = [...schedule, { day: '', events: [] }];
    setAttributes({ schedule: newSchedule });
  };

  const addEvent = dayIndex => {
    const newSchedule = [...schedule];
    newSchedule[dayIndex].events.push({ event: '', activities: [] });
    setAttributes({ schedule: newSchedule });
  };

  const addActivity = (dayIndex, eventIndex) => {
    const newSchedule = [...schedule];
    newSchedule[dayIndex].events[eventIndex].activities.push({
      time: '',
      activity: '',
    });
    setAttributes({ schedule: newSchedule });
  };

  const updateDay = (value, dayIndex) => {
    const newSchedule = [...schedule];
    newSchedule[dayIndex].day = value;
    setAttributes({ schedule: newSchedule });
  };

  const updateEvent = (value, dayIndex, eventIndex) => {
    const newSchedule = [...schedule];
    newSchedule[dayIndex].events[eventIndex].event = value;
    setAttributes({ schedule: newSchedule });
  };

  const updateActivity = (value, dayIndex, eventIndex, activityIndex, key) => {
    const newSchedule = [...schedule];
    newSchedule[dayIndex].events[eventIndex].activities[activityIndex][key] =
      value;
    setAttributes({ schedule: newSchedule });
  };

  const removeDay = dayIndex => {
    if (
      confirm(
        '¿Seguro que deseas eliminar el día?\nSe eliminarán todos los eventos y actividades.'
      )
    ) {
      const newSchedule = [...schedule];
      newSchedule.splice(dayIndex, 1);
      setAttributes({ schedule: newSchedule });
    }
  };

  const removeEvent = (dayIndex, eventIndex) => {
    if (
      confirm(
        '¿Seguro que deseas eliminar el evento?\nSe eliminarán todos las actividades.'
      )
    ) {
      const newSchedule = [...schedule];
      newSchedule[dayIndex].events.splice(eventIndex, 1);
      setAttributes({ schedule: newSchedule });
    }
  };

  const removeActivity = (dayIndex, eventIndex, activityIndex) => {
    const newSchedule = [...schedule];
    newSchedule[dayIndex].events[eventIndex].activities.splice(
      activityIndex,
      1
    );
    setAttributes({ schedule: newSchedule });
  };

  return (
    <div {...useBlockProps()}>
      {schedule.length === 0 && (
        <div class="wp-block-fw-festival-2024-fwf-program__msg">
          <p>Debes agregar un día en la barra lateral</p>
        </div>
      )}

      <InspectorControls>
        <PanelBody title="Configuración del programa">
          <Button variant="primary" onClick={addDay}>
            Agregar Día
          </Button>
        </PanelBody>
      </InspectorControls>
      {schedule.map((day, dayIndex) => (
        <div
          key={dayIndex}
          className="wp-block-fw-festival-2024-fwf-program__day-container"
        >
          {/* <TextControl
            label="Día"
            value={day.day}
            onChange={value => updateDay(value, dayIndex)}
          /> */}

          <RichText
            tagName="h2"
            label="Día"
            value={day.day}
            placeholder="Día"
            onChange={value => updateDay(value, dayIndex)}
            className="wp-block-fw-festival-2024-fwf-program__day-heading"
          />

          <Button variant="secondary" onClick={() => addEvent(dayIndex)}>
            Agregar evento
          </Button>
          <Button
            variant="secondary"
            isDestructive
            onClick={() => removeDay(dayIndex)}
          >
            Eliminar día
          </Button>
          {day.events.map((event, eventIndex) => (
            <div
              key={eventIndex}
              className="wp-block-fw-festival-2024-fwf-program__event-container"
            >
              {/* <TextControl
                label="Evento"
                value={event.event}
                onChange={value => updateEvent(value, dayIndex, eventIndex)}
              /> */}

              <RichText
                tagName="h3"
                label="Evento"
                value={event.event}
                placeholder="Evento"
                onChange={value => updateEvent(value, dayIndex, eventIndex)}
                className="wp-block-fw-festival-2024-fwf-program__event-heading"
              />

              <Button
                variant="secondary"
                onClick={() => addActivity(dayIndex, eventIndex)}
              >
                Agregar Actividad
              </Button>
              <Button
                isDestructive
                variant="secondary"
                onClick={() => removeEvent(dayIndex, eventIndex)}
              >
                Eliminar evento
              </Button>
              {event.activities.map((activity, activityIndex) => (
                <div
                  key={activityIndex}
                  className="wp-block-fw-festival-2024-fwf-program__activity-container"
                >
                  <div className="wp-block-fw-festival-2024-fwf-program__activity-schedule">
                    <RichText
                      tagName="p"
                      label="Horario"
                      placeholder="Horario"
                      value={activity.time}
                      onChange={value =>
                        updateActivity(
                          value,
                          dayIndex,
                          eventIndex,
                          activityIndex,
                          'time'
                        )
                      }
                      className="wp-block-fw-festival-2024-fwf-program__activity-time"
                    />
                    <RichText
                      tagName="p"
                      label="Actividad"
                      value={activity.activity}
                      placeholder="Actividad"
                      onChange={value =>
                        updateActivity(
                          value,
                          dayIndex,
                          eventIndex,
                          activityIndex,
                          'activity'
                        )
                      }
                      className="wp-block-fw-festival-2024-fwf-program__activity-desc"
                    />
                    <Button
                      isDestructive
                      onClick={() =>
                        removeActivity(dayIndex, eventIndex, activityIndex)
                      }
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-x-circle-fill"
                        viewBox="0 0 16 16"
                      >
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                      </svg>
                    </Button>
                  </div>
                </div>
              ))}
            </div>
          ))}
        </div>
      ))}
    </div>
  );
};

export default Edit;
