<template>
  <v-list :light="!dark" :dark="dark">
    <v-list-item-group :value="value" active-class="border">
      <template v-for="(item, i) in items">
        <!-- Group Level 1  -->

        <v-subheader v-if="item.subheader" :key="i" v-text="item.subheader" />

        <v-divider v-else-if="item.divider" :key="i" />

        <v-list-group
          v-else-if="item.items"
          :key="i"
          :value="item.open"
          :prepend-icon="item.icon"
        >
          <template v-slot:activator>
            <v-list-item-title>{{ item.text }}</v-list-item-title>
          </template>

          <template v-for="(item2, i2) in item.items">
            <v-subheader
              v-if="item2.subheader"
              :key="`i2${i2}`"
              v-text="item2.subheader"
            />

            <v-list-group
              v-else-if="item2.items"
              :key="`i2${i2}`"
              :value="item.open"
              no-action
              sub-group
            >
              <template v-slot:activator>
                <v-list-item-content>
                  <v-list-item-title>{{ item2.text }}</v-list-item-title>
                </v-list-item-content>
              </template>

              <template v-for="(item3, i3) in item2.items">
                <v-subheader
                  v-if="item2.subheader"
                  :key="`i3${i3}`"
                  v-text="item2.subheader"
                />

                <v-hover
                  v-else
                  :key="`i3${i3}`"
                  @input="onHover(item3, $event)"
                >
                  <v-list-item
                    link
                    :disabled="isDisabled(item)"
                    :to="item2.to"
                    :exact="item2.exact"
                    @click="onClick(item3)"
                  >
                    <v-list-item-title v-text="item3.text"></v-list-item-title>

                    <v-list-item-icon>
                      <ml-icon :value="item3.icon" :color="item3.iconColor" />
                    </v-list-item-icon>
                  </v-list-item>
                </v-hover>
              </template>
            </v-list-group>

            <v-hover v-else :key="`i2${i2}`" @input="onHover">
              <v-list-item
                :disabled="isDisabled(item)"
                :to="item2.to"
                :exact="item2.exact"
                @click="onClick(item2)"
              >
                <v-list-item-title v-text="item2.text"></v-list-item-title>
                <v-list-item-icon v-if="item2.icon">
                  <ml-icon :value="item2.icon" :color="item2.iconColor" />
                </v-list-item-icon>
              </v-list-item>
            </v-hover>
          </template>
        </v-list-group>

        <v-hover v-else :key="i" @input="onHover">
          <v-list-item
            :disabled="isDisabled(item)"
            :to="item.to"
            :exact="item.exact"
            @click="onClick(item)"
          >
            <v-list-item-icon v-if="item.icon">
              <ml-icon :value="item.icon" :color="item.iconColor" />
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title v-text="item.text"></v-list-item-title>
            </v-list-item-content>
            <v-list-item-icon v-if="item.appendIcon">
              <ml-icon :value="item.appendIcon" :color="item.appendIconColor" />
            </v-list-item-icon>
          </v-list-item>
        </v-hover>
      </template>
    </v-list-item-group>
  </v-list>
</template>

<script>
  const isDisabled = (item) => {
    return (
      item.disabled && (typeof item.disabled == 'boolean' || item.disabled())
    )
  }
  export default {
    props: {
      dark: Boolean,
      value: {
        type: [Number, String],
        default: null,
      },
      items: {
        type: Array,
        default() {
          return []
        },
      },
      onHover: {
        type: Function,
        default() {},
      },
      click: {
        type: [Function, Boolean],
        default: null,
      },
    },
    data() {
      return {
        isDisabled,
      }
    },

    methods: {
      onClick(item) {
        if (item.click) return item.click()
        if (item.to) {
          // clicking to self
          if (item.to.name && item.to.name == this.$route.name) return
          return this.$router.push(item.to)
        }
      },
    },
  }
</script>
