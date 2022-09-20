<template>
  <div>
    <aws-buckets-stepper v-model="data.step" v-bind="stepper">
      <template v-slot:top>
        <slot name="top" />
      </template>
      <template v-slot:step1>
        <add-bucket-step-1 />
      </template>
      <template v-slot:step2>
        <add-bucket-step-2 />
      </template>
      <template v-slot:step3>
        <add-bucket-step-3 />
      </template>
    </aws-buckets-stepper>

    <!--     
    <m-code>
      {{ data }}
    </m-code> -->
  </div>
</template>

<script>
import mixin from './mixins'
export default {
  mixins: [mixin],
  data() {
    return {
      stepper: {
        title: 'Add Bucket',
        width: 550,
        steps: [
          {
            text: 'Create Bucket',
            value: 'step1',
            title: 'Create Bucket In Amazon S3',
            description:
              'For new buckets, please first create the bucket inside your Amazon S3.',
          },
          {
            text: 'Set CORS',
            value: 'step2',
            title: 'Cross-origin resource sharing (CORS)',
            description: 'Add the following snippet to your bucket.',
          },
          {
            text: 'Customize',
            value: 'step3',
            title: 'Optional Bucket Customization',
            description: 'You can make any customizations now or later.',
          },
        ],
      },
    }
  },
}
</script>
