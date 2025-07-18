<template>
  <aside
    :class="[
      'fixed mt-16 flex flex-col lg:mt-0 top-0 px-5 left-0 bg-white dark:bg-gray-900 dark:border-gray-800 text-gray-900 h-screen transition-all duration-300 ease-in-out z-99999 border-r border-gray-200',
      {
        'lg:w-[290px]': isExpanded || isMobileOpen || isHovered,
        'lg:w-[90px]': !isExpanded && !isHovered,
        'translate-x-0 w-[290px]': isMobileOpen,
        '-translate-x-full': !isMobileOpen,
        'lg:translate-x-0': true,
      },
    ]"
    @mouseenter="!isExpanded && (isHovered = true)"
    @mouseleave="isHovered = false"
  >
    <div
      :class="[
        'flex justify-center',
        !isExpanded && !isHovered ? 'py-5' : 'py-5',
      ]"
    >
      <Link to="/">
        <img
          v-if="isExpanded || isHovered || isMobileOpen"
          class="dark:hidden"
          :src="page.props.settings.logo"
          alt="Logo"
          width="100"
          height="40"
        />
        <img
          v-if="isExpanded || isHovered || isMobileOpen"
          class="hidden dark:block"
          :src="page.props.settings.logo"
          alt="Logo"
          width="100"
          height="40"
        />
        <img
          v-else
          :src="page.props.settings.logo"
          alt="Logo"
          width="40"
          height="32"
        />
      </Link>
    </div>
    <div
      class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar"
    >
      <nav class="mb-6">
        <div class="flex flex-col gap-4">
          <div v-for="(menuGroup, groupIndex) in menuGroups" :key="groupIndex">
            <h2 v-if="menuGroup.role.includes(page.props.auth.user.role)"
              :class="[
                'mb-4 text-xs uppercase flex leading-[20px] text-gray-400',
                !isExpanded && !isHovered
                  ? 'lg:justify-center'
                  : 'justify-start',
              ]"
            >
              <template v-if="isExpanded || isHovered || isMobileOpen">
                {{ menuGroup.title }}
              </template>
              <HorizontalDots v-else />
            </h2>
            <ul class="flex flex-col" :class="menuGroup.role.includes(page.props.auth.user.role) ? 'gap-4' : ''">
              <li v-for="(item, index) in menuGroup.items" :key="item.name">
                <button
                  v-if="item.subItems"
                  @click="toggleSubmenu(groupIndex, index)"
                  :class="[
                    'menu-item group w-full',
                    {
                      'menu-item-active': isSubmenuOpen(groupIndex, index),
                      'menu-item-inactive': !isSubmenuOpen(groupIndex, index),
                    },
                    !isExpanded && !isHovered
                      ? 'lg:justify-center'
                      : 'lg:justify-start',
                  ]"
                >
                  <span
                    :class="[
                      isSubmenuOpen(groupIndex, index)
                        ? 'menu-item-icon-active'
                        : 'menu-item-icon-inactive',
                    ]"
                  >
                    <component :is="item.icon" />
                  </span>
                  <span
                    v-if="isExpanded || isHovered || isMobileOpen"
                    class="menu-item-text"
                    >{{ item.name }}</span
                  >
                  <ChevronDownIcon
                    v-if="isExpanded || isHovered || isMobileOpen"
                    :class="[
                      'ml-auto w-5 h-5 transition-transform duration-200',
                      {
                        'rotate-180 text-brand-500': isSubmenuOpen(
                          groupIndex,
                          index
                        ),
                      },
                    ]"
                  />
                </button>
                <Link
                  :preserve-scroll="true"
                  v-else-if="item.path"
                  :href="item.path"
                  :class="[
                    'menu-item group',
                    {
                      'menu-item-active': isActive(item.path),
                      'menu-item-inactive': !isActive(item.path),
                    },
                  ]"
                >
                  <span
                    :class="[
                      isActive(item.path)
                        ? 'menu-item-icon-active'
                        : 'menu-item-icon-inactive',
                    ]"
                  >
                    <component :is="item.icon" />
                  </span>
                  <span
                    v-if="isExpanded || isHovered || isMobileOpen"
                    class="menu-item-text"
                    >{{ item.name }}</span
                  >
                </Link>
                <transition
                  @enter="startTransition"
                  @after-enter="endTransition"
                  @before-leave="startTransition"
                  @after-leave="endTransition"
                >
                  <div
                    v-show="
                      isSubmenuOpen(groupIndex, index) &&
                      (isExpanded || isHovered || isMobileOpen)
                    "
                  >
                    <ul class="mt-2 space-y-1 ml-9">
                      <li v-for="subItem in item.subItems" :key="subItem.name">
                        <Link
                          :preserve-scroll="true"
                          :href="subItem.path"
                          :class="[
                            'menu-dropdown-item',
                            {
                              'menu-dropdown-item-active': isActive(
                                subItem.path
                              ),
                              'menu-dropdown-item-inactive': !isActive(
                                subItem.path
                              ),
                            },
                          ]"
                        >
                          {{ subItem.name }}
                          <span class="flex items-center gap-1 ml-auto">
                            <span
                              v-if="subItem.new"
                              :class="[
                                'menu-dropdown-badge',
                                {
                                  'menu-dropdown-badge-active': isActive(
                                    subItem.path
                                  ),
                                  'menu-dropdown-badge-inactive': !isActive(
                                    subItem.path
                                  ),
                                },
                              ]"
                            >
                              new
                            </span>
                            <span
                              v-if="subItem.pro"
                              :class="[
                                'menu-dropdown-badge',
                                {
                                  'menu-dropdown-badge-active': isActive(
                                    subItem.path
                                  ),
                                  'menu-dropdown-badge-inactive': !isActive(
                                    subItem.path
                                  ),
                                },
                              ]"
                            >
                              pro
                            </span>
                          </span>
                        </Link>
                      </li>
                    </ul>
                  </div>
                </transition>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </aside>
</template>

<script setup>
import { ref, computed } from "vue";
import { useSidebar } from "@/Composables/useSidebar";
import { Link, usePage } from "@inertiajs/vue3";
import UserCircleIcon from "@/Icons/UserCircleIcon.vue";
import CategoryIcon from "@/Icons/CategoryIcon.vue";
import TagIcon from "@/Icons/TagIcon.vue";
import ContentTypeIcon from "@/Icons/ContentTypeIcon.vue";
import SettingsIcon from "@/Icons/SettingsIcon.vue";
import EmailIcon from "@/Icons/EmailIcon.vue";
import MenuIcon from "@/Icons/MenuIcon.vue";
import BriefCaseIcon from "@/Icons/BriefCaseIcon.vue";
import NewsIcon from "@/Icons/NewsIcon.vue";
import GridIcon from "@/Icons/GridIcon.vue";
import ProgramIcon from "@/Icons/ProgramIcon.vue";
import ProgramsIcon from "@/Icons/ProgramsIcon.vue";
import UserCheckIcon from "@/Icons/UserCheckIcon.vue";
import PartnersIcon from "@/Icons/PartnersIcon.vue";
import ImageIcon from "@/Icons/ImageIcon.vue";
import PinIcon from "@/Icons/PinIcon.vue";
import LocationIcon from "@/Icons/LocationIcon.vue";
import ToolsIcon from "@/Icons/ToolsIcon.vue";

  const page = usePage();

const { isExpanded, isMobileOpen, isHovered, openSubmenu } = useSidebar();

const menuGroups = [
  {
    title: "",
    role: ['admin', 'manager', 'staff'],
    items: [
      {
        icon: EmailIcon,
        name: "Inbox",
        path: "/admin/inbox",
        role: ['admin', 'manager', 'staff']
      },
      {
        icon: PinIcon,
        name: "Subscribtions",
        path: "/admin/subscriber",
        role: ['admin', 'manager', 'staff']
      }
    ]
  },
  {
    title: "Master Data",
    role: ['admin', 'manager'],
    items: [
      {
        icon: CategoryIcon,
        name: "Category",
        path: '/admin/category',
        role: ['admin', 'manager']
      },
      {
        icon: TagIcon,
        name: "Tag",
        path: '/admin/tag',
        role: ['admin', 'manager']
      },
      {
        icon: LocationIcon,
        name: "Location",
        path: "/admin/location",
        role: ['admin', 'manager']
      },
      // {
      //   icon: ContentTypeIcon,
      //   name: "Content Type",
      //   path: '/admin/content-type',
      //   role: ['admin', 'manager']
      // },
    ]
  },
  // {
  //   title: "Menu",
  //   role: ['admin', 'manager', 'staff'],
  //   items: [
  //     {
  //       icon: MenuIcon,
  //       name: "Menu",
  //       path: "/admin/menu",
  //       role: ['admin', 'manager', 'staff']
  //     },
  //     {
  //       icon: ImageIcon,
  //       name: "Static Page",
  //       path: "/admin/static-page",
  //       role: ['admin', 'manager', 'staff']
  //     }
  //   ]
  // },
  {
    title: "Career",
    role: ['admin', 'manager', 'staff'],
    items: [
      {
        icon: BriefCaseIcon,
        name: "Career",
        path: "/admin/career",
        role: ['admin', 'manager', 'staff']
      }
    ]
  },
  {
    title: "Media",
    role: ['admin', 'manager', 'staff'],
    items: [
      {
        icon: ImageIcon,
        name: "Banner Management",
        path: "/admin/banner",
        role: ['admin', 'manager', 'staff']
      },
      {
        icon: MenuIcon,
        name: "Our Impact Management",
        path: "/admin/our-impact-management",
        role: ['admin', 'manager', 'staff']
      },
      {
        icon: ContentTypeIcon,
        name: "Instagram Post",
        path: '/admin/instagram',
        role: ['admin', 'manager']
      },
    ]
  },
  {
    title: 'Media',
    role: ['admin', 'manager', 'staff'],
    items: [
      {
        icon: NewsIcon,
        name: "Content Management",
        path: "/admin/content",
        role: ['admin', 'manager', 'staff']
      },
      // {
      //   icon: GridIcon,
      //   name: "Resource",
      //   path: "/admin/resource",
      //   role: ['admin', 'manager', 'staff']
      // },
      {
        icon: GridIcon,
        name: "CFCN Management",
        role: ['admin', 'manager', 'staff'],
        subItems: [
          {
            name: "Step",
            path: "/admin/step-cfcn",
            role: ['admin', 'manager', 'staff']
          },
          {
            name: "FAQ",
            path: "/admin/faq",
            role: ['admin', 'manager', 'staff']
          },
        ]
      },
      {
        icon: ProgramIcon,
        name: "Program Category",
        path: "/admin/program-categories",
        role: ['admin', 'manager', 'staff']
      },
      {
        icon: ProgramsIcon,
        name: "Program",
        path: "/admin/program",
        role: ['admin', 'manager', 'staff']
      },
    ]
  },
  {
    title: "Team Management",
    role: ['admin', 'manager', 'staff'],
    items: [
      {
        icon: ToolsIcon,
        name: "Our Team Management",
        role: ['admin', 'manager', 'staff'],
        subItems: [
          {
            name: "Management",
            path: "/admin/management",
            role: ['admin', 'manager', 'staff']
          },
          {
            name: "Organization",
            path: "/admin/organization",
            role: ['admin', 'manager', 'staff']
          },
        ]
      },
      {
        icon: PartnersIcon,
        name: "Grantee Management",
        path: "/admin/grantee-partner-management",
      },
      {
        icon: UserCheckIcon,
        name: "Grantee User Management",
        path: "/admin/grantee",
      },
      {
        icon: UserCircleIcon,
        name: "User Management",
        path: "/admin/user",
      },
      {
        icon: PartnersIcon,
        name: "Partner Management",
        path: "/admin/partner",
      },
    ],
  },
  {
    title: "Setting",
    role: ['admin'],
    items: [
      {
        icon: SettingsIcon,
        name: "Setting",
        path: "/admin/setting",
        role: ['admin']
      },
    ]
  }
];

const isActive = (path) => page.url === path;

const toggleSubmenu = (groupIndex, itemIndex) => {
  const key = `${groupIndex}-${itemIndex}`;
  openSubmenu.value = openSubmenu.value === key ? null : key;
};

const isAnySubmenuRouteActive = computed(() => {
  return menuGroups.some((group) =>
    group.items.some(
      (item) =>
        item.subItems && item.subItems.some((subItem) => isActive(subItem.path))
    )
  );
});

const isSubmenuOpen = (groupIndex, itemIndex) => {
  const key = `${groupIndex}-${itemIndex}`;
  return (
    openSubmenu.value === key ||
    (isAnySubmenuRouteActive.value &&
      menuGroups[groupIndex].items[itemIndex].subItems?.some((subItem) =>
        isActive(subItem.path)
      ))
  );
};

const startTransition = (el) => {
  el.style.height = "auto";
  const height = el.scrollHeight;
  el.style.height = "0px";
  el.offsetHeight; // force reflow
  el.style.height = height + "px";
};

const endTransition = (el) => {
  el.style.height = "";
};
</script>
