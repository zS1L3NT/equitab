import { ScreenOptions as TopTabsScreenOptions } from "@/lib/top-tabs"
import { createMaterialTopTabNavigator } from "@react-navigation/material-top-tabs"
import FriendsTab from "./friends"
import GroupsTab from "./groups"

const Tab = createMaterialTopTabNavigator()

export default function HomeScreen() {
	return (
		<Tab.Navigator initialRouteName="Friends" screenOptions={TopTabsScreenOptions}>
			<Tab.Screen name="Friends" component={FriendsTab} />
			<Tab.Screen name="Groups" component={GroupsTab} />
		</Tab.Navigator>
	)
}
