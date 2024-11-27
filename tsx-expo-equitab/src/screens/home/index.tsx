import { createMaterialTopTabNavigator } from "@react-navigation/material-top-tabs"
import DirectTab from "./direct"
import GroupTab from "./group"

const Tab = createMaterialTopTabNavigator()

export default function HomeScreen() {
	return (
		<Tab.Navigator initialRouteName="Direct Tabs">
			<Tab.Screen name="Direct Tabs" component={DirectTab} />
			<Tab.Screen name="Group Tabs" component={GroupTab} />
		</Tab.Navigator>
	)
}
