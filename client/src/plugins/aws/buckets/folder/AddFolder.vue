<template>
  <aws-buckets-stepper v-model="data.step" v-bind="stepper">
    <template v-slot:top>
      <slot name="top" />
    </template>
    <template v-slot:step1>
      <add-folder-step-1 />
    </template>
    <template v-slot:step2>
      <add-folder-step-2 />
    </template>
  </aws-buckets-stepper>
</template>

<script>
import mixin from './mixins'
export default {
  mixins: [mixin],
  data() {
    return {
      stepper: {
        title: 'Add Folder',
        width: 550,
        steps: [
          {
            text: 'Folder Name',
            value: 'step1',
            title: 'Folder Name',
            description:
              'This folder name will be created inside your Amazon S3 bucket.',
          },
          // {
          //   text: 'Set CORS',
          //   value: 'step2',
          //   title: 'Cross-origin resource sharing (CORS)',
          //   description: 'Add the following snippet to your bucket.',
          // },
          {
            text: 'Customize',
            value: 'step2',
            title: 'Optional Folder Customization',
            description: 'You can make any customizations now or later.',
          },
        ],
      },
    }
  },
}
</script>
